<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 10:49
 */

namespace app\lib\api\yandex\direct\helpers;

use yii\helpers\ArrayHelper;

class YandexHelper
{
    /**
     * Приводит первый символ названия полей возвращенных через api yandex из верхнего регистра в нижний,
     * например, TimeZone -> timeZone
     * 
     * @param array $item
     * @return array
     */
    public static function convertFieldNames(array $item)
    {
        $resultItem = [];

        foreach ($item as $field => $value) {
            if (is_array($value) && ArrayHelper::isAssociative($value)) {
                $resultItem[self::convertFieldName($field)] = self::convertFieldNames($value);
            } else {
                $resultItem[self::convertFieldName($field)] = $value;
            }
        }

        return $resultItem;
    }

    /**
     * @param string $fieldName
     * @return string
     */
    public static function convertFieldName($fieldName)
    {
        if (strlen($fieldName) > 1) {
            return strtolower(substr($fieldName, 0, 1)) . substr($fieldName, 1);
        } else {
            return $fieldName;
        }
    }
}
