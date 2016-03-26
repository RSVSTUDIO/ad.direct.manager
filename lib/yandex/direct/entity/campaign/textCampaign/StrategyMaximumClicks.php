<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 18:31
 */

namespace app\lib\yandex\direct\entity\campaign\textCampaign;

use app\lib\yandex\direct\entity\BaseEntity;

class StrategyMaximumClicks extends BaseEntity
{
    /**
     * @var int
     */
    public $weeklySpendLimit;

    /**
     * @var int
     */
    public $bidCeiling;
}