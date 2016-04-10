<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 10.04.16
 * Time: 21:34
 */

namespace app\lib\provider;

use app\lib\api\yandex\direct\Connection;
use app\lib\api\yandex\direct\resources\CampaignResource;
use app\models\Shop;
use app\models\YandexCampaign;
use yii\data\ActiveDataProvider;

class ActiveCampaignProvider extends ActiveDataProvider
{
    /**
     * @var CampaignResource[]
     */
    protected static $resources = [];

    /**
     * @inheritDoc
     */
    protected function prepareModels()
    {
        /** @var YandexCampaign[] $models */
        $models = parent::prepareModels();
        if (empty($models)) {
            return $models;
        }
        
        $campaignIds = [];
        
        foreach ($models as $model) {
            $campaignIds[$model->shop_id][] = $model->yandex_id;
        }

        if (empty($campaignIds)) {
            return $models;
        }

        $campaigns = $this->loadCampaigns($campaignIds);

        foreach ($models as $model) {
            if (isset($campaigns[$model->yandex_id])) {
                $model->yandexData = $campaigns[$model->yandex_id];
            }
        }

        return $models;
    }

    /**
     * @param array $campaigns
     * @return array
     */
    protected function loadCampaigns($campaigns)
    {
        $items = [];
        foreach ($campaigns as $shopId => $campaignIds) {
            $resource = $this->getCampaignResourceByShop($shopId);
            $result = $resource->findByIds($campaignIds);
            foreach ($result as $item) {
                $items[$item['Id']] = $item;
            }
        }

        return $items;
    }

    /**
     * @param $shopId
     * @return CampaignResource
     */
    protected function getCampaignResourceByShop($shopId)
    {
        if (empty(self::$resources[$shopId])) {
            $shop = Shop::findOne($shopId);
            self::$resources[$shopId] = new CampaignResource(new Connection($shop->yandex_access_token));
        }

        return self::$resources[$shopId];
    }
}
