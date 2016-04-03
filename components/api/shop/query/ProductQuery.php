<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 08.03.16
 * Time: 22:09
 */

namespace app\components\api\shop\query;


class ProductQuery extends BaseQuery
{
    /**
     * @var int|int[]
     */
    protected $ids;

    /**
     * @var float
     */
    protected $priceFrom;

    /**
     * @var float
     */
    protected $priceTo;

    /**
     * @var int|int[]
     */
    protected $brandId;

    /**
     * Только активные
     * @var bool
     */
    protected $onlyActive = true;

    /**
     * @param int|int[] $ids
     * @return $this
     */
    public function byIds($ids)
    {
        $this->ids= $ids;
        return $this;
    }

    /**
     * @param float $from
     * @return $this
     */
    public function priceFrom($from)
    {
        $this->priceFrom = $from;
        return $this;
    }

    /**
     * @param float $to
     * @return $this
     */
    public function priceTo($to)
    {
        $this->priceTo = $to;
        return $this;
    }

    /**
     * @param int|int[] $id
     * @return $this
     */
    public function byBrandId($id)
    {
        $this->brandId = $id;
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
