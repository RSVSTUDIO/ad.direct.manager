<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 14:14
 */

namespace app\lib\api\yandex\direct\entity\campaign;

use app\lib\api\yandex\direct\entity\BaseEntity;
use yii\base\Object;

class TimeTargeting extends BaseEntity
{
    /**
     * @var array
     */
    public $schedule = [];

    /**
     * @var string
     */
    public $considerWorkingWeekends;

    /**
     * @var \app\lib\api\yandex\direct\entity\campaign\TimeTargetingOnPublicHolidays
     */
    public $holidaySchedule;
}