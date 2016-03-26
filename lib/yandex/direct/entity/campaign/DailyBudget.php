<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 14:30
 */

namespace app\lib\yandex\direct\entity\campaign;

use yii\base\Object;

class DailyBudget extends Object
{
    /**
     * @var int
     */
    public $amount;

    /**
     * @var string
     */
    public $mode;
}
