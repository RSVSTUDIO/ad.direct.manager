<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 14:33
 */

namespace app\lib\yandex\direct\entity\campaign;
use yii\base\Object;

class Notification extends Object
{
    /**
     * @var \app\lib\yandex\direct\entity\campaign\notification\EmailSettings
     */
    public $smsSettings;

    /**
     * @var \app\lib\yandex\direct\entity\campaign\notification\SmsSettings
     */
    public $emailSettings;
}