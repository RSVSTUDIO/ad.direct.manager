<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 27.03.16
 * Time: 12:04
 */

namespace app\models\forms;

use app\lib\api\yandex\direct\Connection;
use app\lib\api\yandex\direct\entity\Campaign;
use app\lib\api\yandex\direct\mappers\CampaignMapper;
use app\models\Shop;
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
        $shop = Shop::findOne($this->shopId);
        $connection = new Connection($shop->yandex_access_token);
        $campaignMapper = new CampaignMapper($connection);
        
        $campaign = [
            'Id' => $this->id,
            'Name' => $this->name,
            'ClientInfo' => $this->clientInfo
        ];
        
        return $campaignMapper->update($campaign);
    }
}