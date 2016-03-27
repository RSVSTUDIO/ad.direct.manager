<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 17:42
 */

namespace app\lib\yandex\direct\entity\campaign\fundsParam;

use app\lib\yandex\direct\entity\BaseEntity;
use yii\base\Object;

class SharedAccountFundsParam extends BaseEntity
{
    /**
     * @var int
     */
    public $refund;

    /**
     * @var int
     */
    public $spend;

}
