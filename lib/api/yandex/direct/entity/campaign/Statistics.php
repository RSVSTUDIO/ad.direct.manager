<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 14:40
 */

namespace app\lib\yandex\direct\entity\campaign;

use app\lib\yandex\direct\entity\BaseEntity;
use yii\base\Object;

class Statistics extends BaseEntity
{
    /**
     * @var int
     */
    public $impressions;

    /**
     * @var int
     */
    public $clicks;
}