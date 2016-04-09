<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 08.03.16
 * Time: 22:06
 */

namespace app\lib\api\shop\query;

class BrandQuery extends BaseQuery
{
    /**
     * @var
     */
    protected $id;

    /**
     * Выводить только активные
     * @var bool
     */
    protected $onlyActive = true;

    /**
     * @param mixed $id
     * @return $this
     */
    public function byId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param bool $val
     * @return $this
     */
    public function onlyActive($val = true)
    {
        $this->onlyActive = $val;
        return $this;
    }
}
