<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 09.04.16
 * Time: 7:50
 */

namespace app\lib\operations;

use app\components\ConsoleLogger;
use app\components\LoggerInterface;
use app\lib\api\shop\gateways\ProductsGateway;
use app\lib\api\shop\models\ApiProduct;
use app\lib\api\yandex\direct\Connection;
use app\lib\api\yandex\direct\exceptions\YandexException;
use app\lib\api\yandex\direct\resources\AdGroupResource;
use app\lib\api\yandex\direct\resources\AdResource;
use app\lib\api\yandex\direct\resources\CampaignResource;
use app\lib\api\yandex\direct\resources\KeywordsResource;
use app\lib\services\AdGroupService;
use app\lib\services\AdService;
use app\lib\services\KeywordsService;
use app\lib\services\YandexCampaignService;
use app\models\Product;
use app\models\Shop;
use app\models\YandexCampaign;
use app\models\YandexUpdateLog;
use yii\helpers\ArrayHelper;

class YandexUpdateOperation implements OperationInterface
{
    /**
     * @var Shop
     */
    protected $shop;

    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var AdGroupService
     */
    protected $adGroupService;

    /**
     * @var AdService
     */
    protected $adService;

    /**
     * @var KeywordsService
     */
    protected $keywordsService;

    /**
     * @var YandexCampaignService
     */
    protected $campaignService;

    /**
     * @var ProductsGateway
     */
    protected $productsGateway;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Служебная информация о ходе выполнения операции
     * @var array
     */
    protected $statistics = [
        'errors' => [],
        'updated' => [],
        'deleted' => [],
        'created' => []
    ];

    /**
     * YandexUpdate constructor.
     * @param Shop $shop
     * @param Connection $connection
     */
    public function __construct(Shop $shop, Connection $connection)
    {
        $this->shop = $shop;
        $this->connection = $connection;
        $this->init();
    }

    protected function init()
    {
        $this->logger = new ConsoleLogger();
        $campaignResource = new CampaignResource($this->connection);
        $adGroupResource = new AdGroupResource($this->connection);
        $adResource = new AdResource($this->connection);
        $keywordsResource = new KeywordsResource($this->connection);

        $this->adGroupService = new AdGroupService($adGroupResource);
        $this->adService = new AdService($adResource);
        $this->keywordsService = new KeywordsService($keywordsResource);
        $this->campaignService = new YandexCampaignService($campaignResource);

        $this->productsGateway = new ProductsGateway(
            $this->shop->product_api_url, $this->shop->api_secret_key
        );
    }

    /**
     * @param int[] $productIds
     * @return ApiProduct[]
     */
    protected function getProductsFromApi($productIds)
    {
        $apiProducts = $this->productsGateway->findByIds($productIds);

        $result = [];

        foreach ($apiProducts as $product) {
            $result[$product['id']] = new ApiProduct($product);
        }

        return $result;
    }

    public function execute($context = [])
    {
        $productQuery = Product::find()
            ->andWhere(['shop_id' => $this->shop->id])
            ->orderBy('id');

        /** @var Product[] $products */
        foreach ($productQuery->batch() as $products) {
            $productIds = ArrayHelper::getColumn($products, 'product_id');
            $apiProducts = $this->getProductsFromApi($productIds);

            foreach ($products as $product) {
                $this->logger->log('Start product id - ' . $product->id);
                if (empty($apiProducts[$product->product_id])) {
                    $this->statistics['errors'][] = [
                        'id' => $product->product_id,
                        'message' => 'Not loaded from api'
                    ];
                    continue;
                }
                //описание товара полученное через api
                $apiProduct = $apiProducts[$product->product_id];

                if (!$product->yandex_campaign_id) {
                    $yaCampaign = $this->campaignService->getCampaign($this->shop->id, $apiProduct->getBrandId());
                    if (!$yaCampaign) {
                        $yaCampaign = $this->createCampaign($apiProduct);
                    }
                    $product->yandex_campaign_id = $yaCampaign->id;
                    $product->save();
                } else {
                    $yaCampaign = $product->yandexCampaign;
                }

                $productUpdateLog = new YandexUpdateLog([
                    'shop_id' => $this->shop->id,
                    'task_id' => 1,
                    'entity_type' => 'product',
                    'entity_id' => $product->id,
                    'status' => YandexUpdateLog::STATUS_SUCCESS
                ]);

                try {
                    $this->processProductUpdate($product, $apiProduct, $yaCampaign, $productUpdateLog);
                } catch (YandexException $e) {
                    $productUpdateLog->status = YandexUpdateLog::STATUS_ERROR;
                    $productUpdateLog->message = $e->getMessage();
                    $productUpdateLog->save();
                }
            }
        }
    }

    /**
     * @param Product $product
     * @param ApiProduct $apiProduct
     * @param YandexCampaign $yaCampaign
     * @param YandexUpdateLog $updateLog
     * @throws YandexException
     */
    protected function processProductUpdate(
        Product $product,
        ApiProduct $apiProduct,
        YandexCampaign $yaCampaign,
        YandexUpdateLog $updateLog
    ) {
        if (empty($product->yandex_ad_id) && $product->is_available) {
            $updateLog->operation = YandexUpdateLog::OPERATION_CREATE;
            $product->yandex_adgroup_id = $this->adGroupService->createAdGroup($product);
            $product->yandex_ad_id = $this->adService->createAd($product, $apiProduct);
            $yaCampaign->incrementProductsCount();
            $this->keywordsService->createKeywordsFor($product);
            $this->logger->log(sprintf('Create ad for product %d, %s', $product->id, $product->title));
            $updateLog->save();
        } elseif (!$apiProduct->isAvailable) {
            $updateLog->operation = YandexUpdateLog::OPERATION_REMOVE;
            $product->is_available = $apiProduct->isAvailable;
            $this->adService->removeAd($product);
            $this->logger->log(sprintf('Remove ad for product %d, %s', $product->id, $product->title));
            $updateLog->save();
        } elseif ($product->price != $apiProduct->price) {
            $updateLog->operation = YandexUpdateLog::OPERATION_UPDATE;
            $product->price = $apiProduct->price;
            $this->adService->update($product, $apiProduct);
            $this->logger->log(sprintf('Update ad for product %d, %s', $product->id, $product->title));
            $updateLog->save();
        }

        $product->save();
    }

    /**
     * Создание новой кампании
     *
     * @param ApiProduct $apiProduct
     * @return \app\models\YandexCampaign
     */
    protected function createCampaign(ApiProduct $apiProduct)
    {
        $campaignLog = new YandexUpdateLog([
            'task_id' => 1,
            'shop_id' => $this->shop->id,
            'entity_type' => 'campaign',
            'operation' => YandexUpdateLog::OPERATION_CREATE
        ]);

        try {
            $yaCampaign = $this->campaignService->createCampaign(
                $apiProduct->getBrandTitle(), $this->shop->id, $apiProduct->getBrandId()
            );
        } catch (YandexException $e) {
            $campaignLog->status = YandexUpdateLog::STATUS_ERROR;
            $campaignLog->message = $e->getMessage();
            $campaignLog->save();
            $this->logger->log('Fail on create campaign: ' . $e->getMessage());

            throw new $e;
        }

        $this->logger->log('Create campaign, campaign id - ' . $yaCampaign->id);
        $campaignLog->entity_id = $yaCampaign->id;
        $campaignLog->status = YandexUpdateLog::STATUS_SUCCESS;

        return $yaCampaign;
    }
}
