<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 18:42
 */

namespace app\lib\yandex\direct\entity\campaign\textCampaign;

use app\lib\yandex\direct\entity\BaseEntity;

class StrategyAverageCpc extends BaseEntity
{
    /**
     * @var int
     */
    public $averageCpc;

    /**
     * @var int
     */
    public $weeklySpendLimit;
}