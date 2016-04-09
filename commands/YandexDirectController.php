<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 27.03.16
 * Time: 19:11
 */

namespace app\commands;

use app\lib\api\shop\gateways\ProductsGateway;
use app\lib\services\AdGroupService;
use app\lib\services\AdService;
use app\lib\services\ShopProductService;
use app\lib\services\YandexCampaignService;
use app\lib\api\yandex\direct\Connection;
use app\lib\api\yandex\direct\resources\AdGroupResource;
use app\lib\api\yandex\direct\resources\AdResource;
use app\lib\api\yandex\direct\resources\CampaignResource;
use app\lib\api\yandex\direct\resources\KeywordsResource;
use app\models\Product;
use app\models\Shop;
use app\models\YandexOauth;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

class YandexDirectController extends Controller
{
    const LIMIT_PER_ITERATION = 200; 
    
    public function actionIndex()
    {
        $data = $this->getStub();
        /** @var Shop $shop */
        $shop = Shop::findOne($data['context']['shopId']);

        $productsGateway = new ProductsGateway($shop->product_api_url, $shop->api_secret_key);

        $yaConnection = new Connection(YandexOauth::getTokenFor($shop->id, $data['context']['userId']));

        $campaignResource = new CampaignResource($yaConnection);
        $adGroupResource = new AdGroupResource($yaConnection);
        $adResource = new AdResource($yaConnection);
        $keywordsResource = new KeywordsResource($yaConnection);

        $adGroupService = new AdGroupService($adGroupResource);
        $adService = new AdService($adResource);

        $yandexCampaignService = new YandexCampaignService($campaignResource);

        $shopProductService = new ShopProductService($productsGateway);

        $productQuery = Product::find()->andWhere(['shop_id' => $shop->id])->orderBy('id');

        $statistics = [
            'errors' => [],
            'updated' => [],
            'deleted' => [],
            'created' => []
        ];

        /** @var Product[] $products */
        foreach ($productQuery->batch() as $products) {
            $productIds = ArrayHelper::getColumn($products, 'product_id');
            $apiProducts = $shopProductService->findByIds($productIds);
            foreach ($products as $product) {
                if (empty($apiProducts[$product->product_id])) {
                    $statistics['errors'][] = [
                        'id' => $product->product_id,
                        'message' => 'Not loaded from api'
                    ];
                    continue;
                }
                //описание товара полученное через api
                $apiProduct = $apiProducts[$product->product_id];

                $yaCampaign = $yandexCampaignService->getCampaign($shop->id, $apiProduct->getBrandId());
                if (!$yaCampaign) {
                    $yaCampaign = $yandexCampaignService->createCampaign($apiProduct->getBrandTitle(), $shop->id,
                        $apiProduct->getBrandId());
                    $product->yandex_campaign_id = $yaCampaign->id;
                }

                if (empty($product->yandex_ad_id)) {
                    $product->yandex_adgroup_id = $adGroupService->createAdGroup($product);
                    $product->yandex_ad_id = $adService->createAd($product, $apiProduct);
                    $product->save();
                    $statistics['created'][] = $product->id;
                    $yaCampaign->incrementProductsCount();
                } elseif ($data['operation'] == 'updatePrice' && $product->price != $apiProduct->price) {
                    $product->price = $apiProduct->price;
                    $product->save();
                    $adService->update($product, $apiProduct);
                    $statistics['updated'][] = $product->id;
                } elseif ($data['operation'] == 'updateAvailability' && !$apiProduct->isAvailable) {
                    $product->is_available = $apiProduct->isAvailable;
                    $product->save();
                    $adService->deleteAd($product);
                    $statistics['deleted'] = $product->id;
                }
            }
        }
        die;
    }


    protected function getStub()
    {
        return [
            'context' => [
                'shopId' => 1,
                'userId' => 1,
            ],
            'operation' => 'updateAvailability'
        ];
    }

}