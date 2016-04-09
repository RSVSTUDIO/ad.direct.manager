<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 03.04.16
 * Time: 13:21
 */

namespace app\lib\services;

use app\lib\api\shop\gateways\ProductsGateway;
use app\lib\api\shop\models\ApiProduct;
use app\models\Product;
use yii\helpers\ArrayHelper;

class ShopProductService
{
    /**
     * @var ProductsGateway
     */
    protected $gateway;

    /**
     * AdditionalInfoLoaderService constructor.
     * @param ProductsGateway $gateway
     */
    public function __construct(ProductsGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    /**
     * Подгрузка данных из апи
     *
     * @param array $ids
     * @return ApiProduct[]
     */
    public function findByIds(array $ids)
    {
        $apiProducts = $this->gateway->findByIds($ids);

        $result = [];

        foreach ($apiProducts as $product) {
            $result[$product['id']] = new ApiProduct($product);
        }

        return $result;
    }
}
