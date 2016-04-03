<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 03.04.16
 * Time: 13:21
 */

namespace app\lib\services;

use app\components\api\shop\gateways\ProductsGateway;
use app\models\ApiProduct;
use app\models\Product;
use yii\helpers\ArrayHelper;

class AdditionalInfoLoaderService
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
     * @param Product[] $products
     * @return array
     */
    public function load(array $products)
    {
        $productIds = ArrayHelper::getColumn($products, 'product_id');
        $apiProducts = ArrayHelper::index($this->gateway->findByIds($productIds), 'id');
        
        foreach ($products as $key => $product) {
            $productId = $product['product_id'];

            if (empty($apiProducts[$productId])) {
                continue;
            }

            $products[$key]['api_data'] = $apiProducts[$productId];
        }

        return $products;
    }
}
