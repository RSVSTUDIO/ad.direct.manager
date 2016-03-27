<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 27.03.16
 * Time: 19:11
 */

namespace app\commands;

use app\components\api\shop\gateways\ProductsGateway;
use app\components\api\shop\query\ProductQuery;
use app\lib\yandex\direct\Connection;
use app\lib\yandex\direct\query\AdGroupQuery;
use app\lib\yandex\direct\query\CampaignQuery;
use app\lib\yandex\direct\query\selectionCriteria\CampaignCriteria;
use app\lib\yandex\direct\resources\AdGroupResource;
use app\lib\yandex\direct\resources\AdResource;
use app\lib\yandex\direct\resources\CampaignResource;
use app\models\Shop;
use app\models\YandexOauth;
use yii\console\Controller;

class YandexDirectController extends Controller
{
    const LIMIT_PER_ITERATION = 200; 
    
    public function actionIndex()
    {
        $data = $this->getStub();
        /** @var Shop $shop */
        $shop = Shop::findOne($data['context']['shopId']);

        $yaConnection = new Connection(YandexOauth::getTokenFor($shop->id, $data['context']['userId']));
        $adsResource = new AdResource($yaConnection);

        $productsGateway = new ProductsGateway($shop->product_api_url, $shop->api_secret_key);
        $productsQuery = new ProductQuery();

        $page = 1;
        $productsQuery->limit(self::LIMIT_PER_ITERATION);

        $campaign = $this->getCampaignOrCreate($yaConnection);
        $adGroup = $this->getAdGroupOrCreate($yaConnection, $campaign['Id']);
        
        while (true) {
            $products = $productsGateway->findByQuery($productsQuery);

            if (empty($products)) {
                break;
            }

            foreach ($products as $product) {
                $ad = $this->getAdParams($product);
                $ad['AdGroupId'] = $adGroup['Id'];
                $res = $adsResource->add($ad);
                print_r($ad);
                print_r($res);die;
            }

            $page++;
            $productsQuery->setPage($page);
        }

        $productsGateway->totalCount($productsQuery);
    }
    
    protected function getAdGroupOrCreate($connection, $campaignId)
    {
        $agGroupResource = new AdGroupResource($connection);
        $query = new AdGroupQuery();
        $query->selectionCriteria->campaignIds = [$campaignId];

        $result = $agGroupResource->find($query);
        if (!$result->count()) {
            $agGroupResource->add([
                'Name'
            ]);
        } else {
            return $result->first();
        }
    }

    protected function getCampaignOrCreate(Connection $connection)
    {
        $campaignResource = new CampaignResource($connection);
        $query = new CampaignQuery();
        $query->selectionCriteria->setTypes(CampaignCriteria::TYPE_TEXT_CAMPAIGN);

        $result = $campaignResource->find($query);

        return $result->first();
    }
    
    protected function getAdParams($product)
    {
        return [
            'TextAd' => [
                'Text' => 'Продам ' . $product['title'],
                'Title' => $product['title'],
                'Mobile' => 'NO',
                'Href' => 'http://paramount-shop.ru/q-acoustics-7000wb.html'
               // 'AdImageHash' => 'http://paramount-shop.ru/uploads/items/b-2456e36969a4a9fb25bf069816637355.jpg'
            ]
        ];
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