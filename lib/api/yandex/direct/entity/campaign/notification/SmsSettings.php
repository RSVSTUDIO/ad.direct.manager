<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 17:10
 */

namespace app\lib\yandex\direct\entity\campaign\notification;

use app\lib\yandex\direct\entity\BaseEntity;
use yii\base\Object;

class SmsSettings extends BaseEntity
{
    /**
     * @var array
     */
    public $events;

    /**
     * @var string
     */
    public $timeFrom;

    /**
     * @var string
     */
    public $timeTo;
}