<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 27.03.16
 * Time: 19:03
 */

namespace app\lib\yandex\direct\query;

class ModifyResult
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

    public function isSuccess()
    {
        return true;
    }
}