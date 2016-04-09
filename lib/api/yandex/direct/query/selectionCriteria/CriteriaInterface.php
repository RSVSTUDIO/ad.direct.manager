<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 21.03.16
 * Time: 21:57
 */

namespace app\lib\api\yandex\direct\query\selectionCriteria;

interface CriteriaInterface
{
    /**
     * Возвращает массив данных для запроса
     * @return array
     */
    public function getCriteria();
}