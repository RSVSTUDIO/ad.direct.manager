<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 19:06
 */

namespace app\lib\api\yandex\direct\entity\campaign\textCampaign;

use app\lib\api\yandex\direct\entity\BaseEntity;

class RelevantKeywords extends BaseEntity
{
    /**
     * @var int
     */
    public $budgetPercent;

    /**
     * @var string
     */
    public $mode;

    /**
     * @var int
     */
    public $optimizeGoalId;
}