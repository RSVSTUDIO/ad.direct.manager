<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 8:43
 */

namespace app\lib\yandex\direct\entity;


use yii\base\Object;
use yii\debug\components\search\matchers\Base;

class BaseEntity extends Object
{
    /**
     * @return array
     */
    public function toArray()
    {
        $vars = array_filter(get_object_vars($this));

        $result = [];
        foreach ($vars as $fieldName => $value) {
            if ($value instanceof BaseEntity) {
                $result[$fieldName] = $value->toArray();
            } else {
                $result[$fieldName] = $value;
            }
        }

        return $result;
    }
}
