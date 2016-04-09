<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 18:15
 */

namespace app\lib\yandex\direct\entity\campaign\textCampaign;

use app\lib\yandex\direct\entity\BaseEntity;
use yii\base\Object;

class BiddingStrategy extends BaseEntity
{
    /**
     * @var \app\lib\yandex\direct\entity\campaign\textCampaign\TextCampaignSearchStrategy
     */
    public $search;

    /**
     * @var \app\lib\yandex\direct\entity\campaign\textCampaign\TextCampaignNetworkStrategy
     */
    public $network;

    /**
     * @inheritDoc
     */
    public function __construct(array $config = [])
    {
        $this->search = new TextCampaignSearchStrategy();
        $this->network = new TextCampaignNetworkStrategy();
        parent::__construct($config);
    }
}
