<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 09.04.16
 * Time: 7:50
 */

namespace app\lib\operations;

use app\lib\api\shop\gateways\ProductsGateway;
use app\lib\api\shop\models\ApiProduct;
use app\lib\api\yandex\direct\Connection;
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

    public function execute($operation = [])
    {
        $productQuery = Product::find()->andWhere(['shop_id' => $this->shop->id])->orderBy('id');

        /** @var Product[] $products */
        foreach ($productQuery->batch() as $products) {
            $productIds = ArrayHelper::getColumn($products, 'product_id');
            $apiProducts = $this->getProductsFromApi($productIds);

            foreach ($products as $product) {
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
                        $yaCampaign = $this->campaignService->createCampaign(
                            $apiProduct->getBrandTitle(), $this->shop->id, $apiProduct->getBrandId()
                        );
                    }
                    $product->yandex_campaign_id = $yaCampaign->id;
                    $product->save();
                } else {
                    $yaCampaign = $product->yandexCampaign;
                }

                if (empty($product->yandex_ad_id) && $product->is_available) {
                    $product->yandex_adgroup_id = $this->adGroupService->createAdGroup($product);
                    $product->yandex_ad_id = $this->adService->createAd($product, $apiProduct);
                    $product->save();
                    $this->statistics['created'][] = ['id' => $product->id];
                    $yaCampaign->incrementProductsCount();
                } elseif ($operation == 'updatePrice' && $product->price != $apiProduct->price) {
                    $product->price = $apiProduct->price;
                    $this->adService->update($product, $apiProduct);
                    $product->save();
                    $this->statistics['updated'][] = ['id' => $product->id];
                } elseif ($operation == 'updateAvailability' && !$apiProduct->isAvailable) {
                    $product->is_available = $apiProduct->isAvailable;
                    $product->save();
                    $this->adService->removeAd($product);
                    $this->statistics['deleted'] = ['id' => $product->id];
                }
            }
        }

        print_r($this->statistics);
    }
}