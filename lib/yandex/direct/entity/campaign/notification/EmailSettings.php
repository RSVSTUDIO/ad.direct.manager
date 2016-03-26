<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 17:10
 */

namespace app\lib\yandex\direct\entity\campaign\notification;

use yii\base\Object;

class EmailSettings extends Object
{
    /**
     * @var string
     */
    public $email;

    /**
     * @var int
     */
    public $checkPositionInterval;

    /**
     * @var int
     */
    public $warningBalance;

    /**
     * @var string
     */
    public $sendAccountNews;

    /**
     * @var string
     */
    public $sendWarnings;
}