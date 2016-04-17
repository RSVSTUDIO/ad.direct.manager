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
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

class YandexUpdateOperation extends BaseOperation
{
    const OPERATION_YANDEX_UPDATE = 'yandexUpdate';

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

    protected function init()
    {
        /** @var Shop $shop */
        $this->shop = Shop::findOne($this->task->shop_id);

        $this->connection = new Connection($this->shop->yandex_access_token);
        
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

    /**
     * Возвращает запрос на получение товаров
     *
     * @return ActiveQuery
     */
    protected function getQuery()
    {
        $context = $this->task->getContext();
        $criteria = [
            'shop_id' => $context['shopId'],
            'brand_id' => $context['brandIds'],
        ];

        $query = Product::find()
            ->andWhere($criteria)
            ->andWhere('(is_available + yandex_ad_id) != 0')
            ->andWhere("keywords != ''");

        if (!empty($context['priceFrom'])) {
            $query->andWhere(['>=', 'price', $context['priceFrom']]);
        }
        if (!empty($context['priceTo'])) {
            $query->andWhere(['<=', 'price', $context['priceTo']]);
        }

        return $query;
    }

    /**
     * @inheritdoc
     */
    public function execute($params = [])
    {
        $productQuery = $this->getQuery();

        /** @var Product[] $products */
        foreach ($productQuery->batch() as $products) {
            $productIds = ArrayHelper::getColumn($products, 'product_id');
            $apiProducts = $this->getProductsFromApi($productIds);

            foreach ($products as $product) {
                $this->logger->log('Start product id - ' . $product->id);
                if (empty($apiProducts[$product->product_id])) {
                    $this->productNotLoadFromApi($product);
                    continue;
                }
                //описание товара полученное через api
                $apiProduct = $apiProducts[$product->product_id];

                if (!$product->yandex_campaign_id) {
                    $yaCampaign = $this->getOrCreateCampaign($apiProduct);
                    $product->yandex_campaign_id = $yaCampaign->id;
                    $product->save();
                } else {
                    $yaCampaign = $product->yandexCampaign;
                }

                $this->processUpdate($product, $apiProduct, $yaCampaign);
            }
        }
    }

    /**
     * @param ApiProduct $apiProduct
     * @return YandexCampaign
     * @throws YandexException
     */
    protected function getOrCreateCampaign(ApiProduct $apiProduct)
    {
        $yaCampaign = $this->campaignService->getCampaign($this->shop->id, $apiProduct->getBrandId());
        if (!$yaCampaign) {
            $yaCampaign = $this->createCampaign($apiProduct);
        }

        return $yaCampaign;
    }

    /**
     * Обработка ситуации, когда товар не был получен из api
     * @param Product $product
     * @return null
     */
    protected function productNotLoadFromApi(Product $product)
    {
        //елси товара и не было в наличии, возможно товар удалили из базы магазина
        if (!$product->is_available) {
            return null;
        }

        $updateLog = new YandexUpdateLog([
            'shop_id' => $this->shop->id,
            'task_id' => $this->task->id,
            'entity_type' => 'product',
            'entity_id' => $product->id,
            'status' => YandexUpdateLog::STATUS_ERROR,
            'operation' => YandexUpdateLog::OPERATION_API_LOAD,
            'message' => 'Товар не загружен через апи'
        ]);
        $updateLog->save();

        if (!empty($product->yandex_ad_id)) {
            $this->removeAdProduct($product);
        }
    }

    /**
     * Создает объект для логирования операции
     *
     * @param Product $product
     * @param string $operation
     * @param string $status
     * @return YandexUpdateLog
     */
    protected function createUpdateLogForProduct(
        Product $product, $operation, $status = YandexUpdateLog::STATUS_SUCCESS
    ) {
        return new YandexUpdateLog([
            'shop_id' => $this->shop->id,
            'task_id' => $this->task->id,
            'entity_type' => 'product',
            'entity_id' => $product->id,
            'operation' => $operation,
            'status' => $status
        ]);
    }

    /**
     * @param Product $product
     * @param ApiProduct $apiProduct
     * @param YandexCampaign $yaCampaign
     * @throws YandexException
     */
    protected function processUpdate(Product $product, ApiProduct $apiProduct, YandexCampaign $yaCampaign)
    {
        if (empty($product->yandex_ad_id) && $product->is_available) {
            $this->createAdProduct($product, $apiProduct, $yaCampaign);
        } elseif (!$apiProduct->isAvailable) {
            $this->removeAdProduct($product);
        } elseif (!$product->isManualPrice() && $product->price != $apiProduct->price) {
            $this->updateAdProduct($product, $apiProduct);
        }

        $product->save();
    }

    /**
     * Обновление объявления
     *
     * @param Product $product
     * @param ApiProduct $apiProduct
     * @throws YandexException
     */
    protected function updateAdProduct(Product $product, ApiProduct $apiProduct)
    {
        $updateLog = $this->createUpdateLogForProduct($product, YandexUpdateLog::OPERATION_UPDATE);
        $product->price = $apiProduct->price;
        $product->is_available = $apiProduct->isAvailable;
        $this->logger->log(sprintf('Start update ad for product %d, %s', $product->id, $product->title));

        try {
            $this->keywordsService->updateKeywords($product);
            $this->adService->update($product, $apiProduct);
        } catch (YandexException $e) {
            $updateLog->status = YandexUpdateLog::STATUS_ERROR;
            $updateLog->message = $e->getMessage();
        }

        $updateLog->save();
    }

    /**
     * Обновление объявления
     *
     * @param Product $product
     */
    protected function removeAdProduct(Product $product)
    {
        $updateLog = $this->createUpdateLogForProduct($product, YandexUpdateLog::OPERATION_REMOVE);
        $updateLog->operation = YandexUpdateLog::OPERATION_REMOVE;
        $product->is_available = false;
        $this->logger->log(sprintf('Remove ad for product %d, %s', $product->id, $product->title));

        try {
            $this->adService->removeAd($product);
        } catch (YandexException $e) {
            $updateLog->status = YandexUpdateLog::STATUS_ERROR;
            $updateLog->message = $e->getMessage();
        }

        $updateLog->save();
    }

    /**
     * Создание нового объявления
     *
     * @param Product $product
     * @param ApiProduct $apiProduct
     * @param YandexCampaign $yaCampaign
     * @throws YandexException
     */
    protected function createAdProduct(Product $product, ApiProduct $apiProduct, YandexCampaign $yaCampaign)
    {
        $updateLog = $this->createUpdateLogForProduct($product, YandexUpdateLog::OPERATION_CREATE);
        $this->logger->log(sprintf('Create ad for product %d, %s', $product->id, $product->title));

        try {
            if (empty($product->yandex_adgroup_id)) {
                $product->yandex_adgroup_id = $this->adGroupService->createAdGroup($product);
            }
            $this->keywordsService->createKeywordsFor($product);
            $product->yandex_ad_id = $this->adService->createAd($product, $apiProduct);
            $yaCampaign->incrementProductsCount();
        } catch (YandexException $e) {
            $updateLog->status = YandexUpdateLog::STATUS_ERROR;
            $updateLog->message = $e->getMessage();
        }

        $updateLog->save();
    }

    /**
     * Создание новой кампании
     *
     * @param ApiProduct $apiProduct
     * @return YandexCampaign
     * @throws YandexException
     */
    protected function createCampaign(ApiProduct $apiProduct)
    {
        $campaignLog = new YandexUpdateLog([
            'task_id' => $this->task->id,
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

            throw $e;
        }

        $this->logger->log('Create campaign, campaign id - ' . $yaCampaign->id);
        $campaignLog->entity_id = $yaCampaign->id;
        $campaignLog->status = YandexUpdateLog::STATUS_SUCCESS;
        $campaignLog->save();

        return $yaCampaign;
    }
}
