<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 8:43
 */

namespace app\lib\yandex\direct\entity;


use yii\base\Object;

class BaseEntity extends Object
{
    public static function createFromArray(array $data = [])
    {
        return new static($data);
    }
}
