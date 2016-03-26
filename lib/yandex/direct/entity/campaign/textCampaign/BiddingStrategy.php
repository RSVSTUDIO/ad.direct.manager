<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 18:15
 */

namespace app\lib\yandex\direct\entity\campaign\textCampaign;

use yii\base\Object;

class BiddingStrategy extends Object
{
    /**
     * @var \app\lib\yandex\direct\entity\campaign\textCampaign\TextCampaignSearchStrategy
     */
    public $search;

    /**
     * @var \app\lib\yandex\direct\entity\campaign\textCampaign\TextCampaignNetworkStrategy
     */
    public $network;
}