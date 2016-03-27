<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 27.03.16
 * Time: 12:04
 */

namespace app\models\forms;

use app\lib\yandex\direct\Connection;
use app\lib\yandex\direct\entity\Campaign;
use app\lib\yandex\direct\mappers\CampaignMapper;
use app\models\YandexOauth;
use yii\base\Model;

class CampaignForm extends Model
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $shopId;

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $currency;

    /**
     * @var string
     */
    public $clientInfo;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [['name', 'currency', 'clientInfo'], 'string'],
            [['shopId', 'id'], 'required'],
        ];
    }
    
    public function save()
    {
        $connection = new Connection(YandexOauth::getTokenFor($this->shopId));
        $campaignMapper = new CampaignMapper($connection);
        
        /** @var Campaign $campaignEntity */
        $campaignEntity = $campaignMapper->findById($this->id);
        $campaignEntity->name = $this->name;
        
        $campaignMapper->update($campaignEntity);
    }
}