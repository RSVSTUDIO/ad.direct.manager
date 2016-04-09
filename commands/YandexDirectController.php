<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 27.03.16
 * Time: 19:11
 */

namespace app\commands;

use app\lib\operations\YandexUpdateOperation;
use app\lib\api\yandex\direct\Connection;
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
        
        $yandexUpdateOperation = new YandexUpdateOperation($shop, $yaConnection);

        $yandexUpdateOperation->execute('updatePrice');
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