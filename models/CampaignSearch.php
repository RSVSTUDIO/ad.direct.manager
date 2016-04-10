<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 27.03.16
 * Time: 9:10
 */

namespace app\models;

use app\lib\api\yandex\direct\Connection;
use app\lib\api\yandex\direct\mappers\CampaignMapper;
use app\lib\api\yandex\direct\query\CampaignQuery;
use app\lib\api\yandex\direct\query\selectionCriteria\CampaignCriteria;
use yii\base\Model;
use yii\data\ArrayDataProvider;

class CampaignSearch extends Model
{
    /**
     * @var int
     */
    public $userId;

    /**
     * @var int
     */
    public $shopId;

    /**
     * @var string
     */
    public $campaignType;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [['shopId', 'userId'], 'integer'],
            [['campaignType'], 'string']
        ];
    }

    /**
     * @param array $params
     * @return void|ArrayDataProvider
     */
    public function search($params = [])
    {
        $provider = new ArrayDataProvider([
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        $this->attributes = $params;

        if (!$this->validate()) {
            return $provider;
        }
        
        $shop = Shop::findOne($this->shopId);
        $token = $shop->yandex_access_token;
        
        if (!$token) {
            return $provider;
        }
        
        $criteria = new CampaignCriteria();
        if ($this->campaignType) {
            $criteria->setTypes($this->campaignType);
        }

        $query = new CampaignQuery($criteria);
        $connection = new Connection($token);
        $campaignMapper = new CampaignMapper($connection);

        $result = $campaignMapper->find($query);

        $provider->setModels($result->getItems());

        return $provider;
    }
}