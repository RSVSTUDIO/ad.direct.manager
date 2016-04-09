<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 16:50
 */

namespace app\lib\api\yandex\direct\entity\campaign;

use app\lib\api\yandex\direct\entity\BaseEntity;
use yii\base\Object;

class TimeTargetingOnPublicHolidays extends BaseEntity
{
    /**
     * @var string
     */
    public $suspendOnHolidays;

    /**
     * @var int
     */
    public $bidPercent;

    /**
     * @var int
     */
    public $startHour;

    /**
     * @var int
     */
    public $endHour;
}