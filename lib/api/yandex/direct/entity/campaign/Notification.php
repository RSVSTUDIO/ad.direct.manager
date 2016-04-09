<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 14:33
 */

namespace app\lib\api\yandex\direct\entity\campaign;
use app\lib\api\yandex\direct\entity\BaseEntity;
use yii\base\Object;

class Notification extends BaseEntity
{
    /**
     * @var \app\lib\api\yandex\direct\entity\campaign\notification\EmailSettings
     */
    public $smsSettings;

    /**
     * @var \app\lib\api\yandex\direct\entity\campaign\notification\SmsSettings
     */
    public $emailSettings;
}