<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 21.03.16
 * Time: 21:56
 */

namespace app\lib\yandex\direct\query\selectionCriteria;

use yii\base\Object;

class SelectionCriteria extends Object implements CriteriaInterface
{
    /**
     * @param array $data
     * @return static
     */
    public static function createFromArray(array $data)
    {
        return new static($data);
    }

    /**
     * @inheritDoc
     */
    public function getCriteria()
    {
        $objectVars = array_filter(get_object_vars($this));

        $criteria = [];
        foreach ($objectVars as $field => $value) {
            $criteria[ucfirst($field)] = $value;
        }

        return $criteria;
    }
}
