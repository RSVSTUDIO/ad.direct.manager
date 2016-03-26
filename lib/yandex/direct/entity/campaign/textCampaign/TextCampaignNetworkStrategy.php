<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 18:56
 */

namespace app\lib\yandex\direct\entity\campaign\textCampaign;

use app\lib\yandex\direct\entity\BaseEntity;

class TextCampaignNetworkStrategy extends BaseEntity
{
    /**
     * @var string
     */
    public $biddingStrategyType;

    /**
     * @var \app\lib\yandex\direct\entity\campaign\textCampaign\StrategyNetworkDefault
     */
    public $networkDefault;

    /**
     * @var \app\lib\yandex\direct\entity\campaign\textCampaign\StrategyMaximumClicks
     */
    public $wbMaximumClicks;

    /**
     * @var \app\lib\yandex\direct\entity\campaign\textCampaign\StrategyMaximumConversionRate
     */
    public $wbMaximumConversionRate;

    /**
     * @var \app\lib\yandex\direct\entity\campaign\textCampaign\StrategyAverageCpc
     */
    public $averageCpc;

    /***
     * @var \app\lib\yandex\direct\entity\campaign\textCampaign\StrategyAverageCpa
     */
    public $averageCpa;

    /**
     * @var \app\lib\yandex\direct\entity\campaign\textCampaign\StrategyWeeklyClickPackage
     */
    public $weeklyClickPackage;

    /**
     * @var \app\lib\yandex\direct\entity\campaign\textCampaign\StrategyAverageRoi
     */
    public $averageRoi;
}