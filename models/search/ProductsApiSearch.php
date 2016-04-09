<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 13.03.16
 * Time: 11:32
 */

namespace app\models\search;

use app\lib\api\shop\gateways\ProductsGateway;
use app\lib\api\shop\query\ProductQuery;
use app\lib\provider\ProductsApiDataProvider;
use app\models\Shop;
use yii\base\InvalidParamException;
use yii\base\Model;
use yii\data\DataProviderInterface;

class ProductsApiSearch extends Model
{
    /**
     * @var int
     */
    public $brandId;

    /**
     * @var int
     */
    public $shopId;

    /**
     * @var bool
     */
    public $onlyActive;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [['brandId', 'shopId'], 'integer'],
            ['onlyActive', 'boolean'],
            ['shopId', 'required']
        ];
    }

    /**
     * @param array $params
     * @return DataProviderInterface
     */
    public function search($params = [])
    {
        $query = new ProductQuery();

        if (!empty($params)) {
            $this->load($params);
        }

        if (!$this->validate()) {
            throw new InvalidParamException();
        }

        /** @var Shop $shop */
        $shop = Shop::findOne($this->shopId);
        $productsGateway = new ProductsGateway(
            $shop->product_api_url, $shop->api_secret_key
        );

        $provider = new ProductsApiDataProvider([
            'query' => $query,
            'gateWay' => $productsGateway,
            'key' => 'id',
            'shopId' => $shop->id
        ]);

        $query
            ->onlyActive($this->onlyActive)
            ->byBrandId($this->brandId);

        return $provider;
    }
}
