<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 16:50
 */

namespace app\lib\yandex\direct\entity\campaign;

use yii\base\Object;

class TimeTargetingOnPublicHolidays extends Object
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