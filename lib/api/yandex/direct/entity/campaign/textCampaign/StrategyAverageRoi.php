<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 18:42
 */

namespace app\lib\api\yandex\direct\entity\campaign\textCampaign;

use app\lib\api\yandex\direct\entity\BaseEntity;

class StrategyAverageRoi extends BaseEntity
{
    /**
     * @var int
     */
    public $reserveReturn;

    /**
     * @var int
     */
    public $roiCoef;

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

    /**
     * @var int
     */
    public $profitability;
}