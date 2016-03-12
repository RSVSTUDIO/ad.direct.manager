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
    public $id;

    /**
     * @var float
     */
    public $priceFrom;

    /**
     * @var float
     */
    public $priceTo;

    /**
     * @var int|int[]
     */
    public $brandId;

    /**
     * Только активные
     * @var bool
     */
    public $onlyActive = true;
}
