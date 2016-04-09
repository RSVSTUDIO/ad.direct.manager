<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 14:30
 */

namespace app\lib\api\yandex\direct\entity\campaign;

use app\lib\api\yandex\direct\entity\BaseEntity;
use yii\base\Object;

class DailyBudget extends BaseEntity
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
