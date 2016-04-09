<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 08.03.16
 * Time: 22:07
 */

namespace app\lib\api\shop\query;

interface QueryInterface
{
    /**
     * Возвращает массив параметров для запроса
     *
     * @return array
     */
    public function getQuery();
}