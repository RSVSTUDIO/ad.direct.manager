<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 12.03.16
 * Time: 16:53
 */

namespace app\lib\api\shop\gateways;

use app\lib\api\shop\query\BrandQuery;
use app\lib\api\shop\query\QueryInterface;

class BrandsGateway extends AbstractGateway
{
    /**
     * @param null $limit
     * @return array
     */
    public function getBrandsList($limit = null)
    {
        return $this->query(
            (new BrandQuery())->onlyActive()->limit($limit)
        );
    }
}
