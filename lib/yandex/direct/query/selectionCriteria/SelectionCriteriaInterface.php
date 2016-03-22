<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 21.03.16
 * Time: 21:57
 */

namespace app\lib\yandex\direct\query\selectionCriteria;

interface SelectionCriteriaInterface
{
    /**
     * Возвращает массив данных для запроса
     * @return array
     */
    public function getCriteria();
}