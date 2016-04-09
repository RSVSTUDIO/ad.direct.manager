<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 18:39
 */

namespace app\lib\yandex\direct\entity\campaign\textCampaign;

use app\lib\yandex\direct\entity\BaseEntity;

class StrategyMaximumConversionRate extends BaseEntity
{
    /**
     * @var int
     */
    public $goalId;

    /**
     * @var int
     */
    public $weeklySpendLimit;

    /**
     * @var int
     */
    public $bidCeiling;
}