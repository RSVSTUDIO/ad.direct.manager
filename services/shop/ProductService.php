<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 12.03.16
 * Time: 17:02
 */

namespace app\services\shop;

use app\components\api\shop\gateways\ProductGateway;
use app\components\api\shop\query\QueryInterface;
use app\models\Shop;

class ProductService
{
    /**
     * @var ProductGateway
     */
    protected $productGateway;

    /**
     * ProductService constructor.
     * @param Shop $shop
     */
    public function __construct(Shop $shop)
    {
        $this->productGateway = new ProductGateway(
            $shop->product_api_url, $shop->api_secret_key
        );
    }

    /**
     * @param ProductGateway $productGateway
     * @return $this
     */
    public function setProductGateway(ProductGateway $productGateway)
    {
        $this->productGateway = $productGateway;
        return $this;
    }

    public function findByQuery(QueryInterface $query)
    {

    }
}