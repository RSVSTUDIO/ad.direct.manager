<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 23.03.16
 * Time: 19:28
 */

namespace app\lib\api\yandex\direct\query\selectionCriteria;

class LimitOffset extends SelectionCriteria
{
    /**
     * @var int
     */
    protected $limit = 100;

    /**
     * @var int
     */
    protected $offset = 0;

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
    }
}
