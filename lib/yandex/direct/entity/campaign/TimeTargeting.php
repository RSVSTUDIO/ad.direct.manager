<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 14:14
 */

namespace app\lib\yandex\direct\entity\campaign;

use yii\base\Object;

class TimeTargeting extends Object
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
     * @var \app\lib\yandex\direct\entity\campaign\TimeTargetingOnPublicHolidays
     */
    public $holidaySchedule;
}