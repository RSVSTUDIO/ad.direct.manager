<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 21.03.16
 * Time: 21:56
 */

namespace app\lib\yandex\direct\query\selectionCriteria;

use yii\base\InvalidParamException;

class SelectionCriteria implements SelectionCriteriaInterface
{
    /**
     * SelectionCriteria constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->setFromArray($data);
    }

    /**
     * Установить значения объекта из массива
     * @param array $data
     */
    public function setFromArray(array $data)
    {
        foreach ($data as $field => $value) {
            if (!property_exists($this, $field)) {
                throw new InvalidParamException("Unknown set field - $field");
            }
            $this->$field = $value;
        }
    }

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
