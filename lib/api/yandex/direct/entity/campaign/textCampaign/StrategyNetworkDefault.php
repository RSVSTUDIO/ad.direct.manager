<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 18:58
 */

namespace app\lib\api\yandex\direct\entity\campaign\textCampaign;

use app\lib\api\yandex\direct\entity\BaseEntity;

class StrategyNetworkDefault extends BaseEntity
{
    /**
     * @var int
     */
    public $limitPercent;

    /**
     * @var int
     */
    public $bidPercent;
}