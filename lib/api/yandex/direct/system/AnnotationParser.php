<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 15:25
 */

namespace app\lib\yandex\direct\system;

use app\lib\yandex\direct\helpers\YandexHelper;

class AnnotationParser
{
    const DEFAULT_TYPE = 'string';

    /**
     * @var array
     */
    protected static $cache = [];
    
    /**
     * Возвращает массив название полей и их типов
     * @param string $className
     * @return array
     */
    public function parseAttributes($className)
    {
        if (empty(self::$cache[$className])) {
            $result = [];
            $refClass = new \ReflectionClass($className);
            $properties = $refClass->getProperties();

            foreach ($properties as $property) {
                $comment = $property->getDocComment();
                $result[$property->getName()] = [
                    'type' => $this->getTypeFromComment($comment),
                    'apiName' => ucfirst($property->getName()),
                    'modelName' => YandexHelper::convertFieldName($property->getName())
                ];
            }

            self::$cache[$className] = $result;
        }


        return self::$cache[$className];
    }

    /**
     * @param string $comment
     * @return mixed|string
     */
    protected function getTypeFromComment($comment)
    {
        $lines = explode("\n", $comment);
        foreach ($lines as $line) {
            $match = [];
            if (preg_match('#@var\s+([\w\\\]+)$#', $line, $match)) {
                return $match[1];
            }
        }

        return self::DEFAULT_TYPE;
    }
}
