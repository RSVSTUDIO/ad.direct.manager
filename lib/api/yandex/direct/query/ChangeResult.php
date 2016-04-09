<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 27.03.16
 * Time: 19:03
 */

namespace app\lib\yandex\direct\query;

use yii\helpers\ArrayHelper;

class ChangeResult
{
    /**
     * @var array
     */
    protected $result;

    /**
     * ModifyResult constructor.
     * @param array $result
     */
    public function __construct(array $result)
    {
        $this->result = $result;
    }

    /**
     * Возвращает массив вида [
     * 'Code' => int,
     * 'Message' => string,
     * 'Detail' => string,
     * 'Id' => int
     * ]
     *
     * @return array
     */
    public function firstError()
    {
        $errors = $this->getErrors();

        return reset($errors);
    }

    /**
     * Возвращает список id по которым происходили операции
     * @return array
     */
    public function getIds()
    {
        return array_filter(ArrayHelper::getColumn($this->result, 'Id'));
    }

    /**
     * Возвращает массив ошибок
     * @return array
     */
    public function getErrors()
    {
        $errors = [];
        foreach ($this->result as $itemResult) {
            if (!empty($itemResult['Errors'])) {
                foreach ($itemResult['Errors'] as $errorInfo) {
                    $errors[] = $errorInfo;
                }
            }
        }

        return $errors;
    }

    /**
     * Все операции прошли успешно?
     * @return bool
     */
    public function isSuccess()
    {
        return count($this->getErrors()) == 0;
    }
}
