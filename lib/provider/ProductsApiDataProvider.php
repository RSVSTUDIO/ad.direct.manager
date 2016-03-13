<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 13.03.16
 * Time: 15:26
 */

namespace app\lib\provider;

use app\models\Product;

class ProductsApiDataProvider extends ApiDataProvider
{
    /**
     * @inheritDoc
     */
    protected function loadAdditionalInfo($models)
    {
        $keys = $this->prepareKeys($models);
        $products = $this->getProducts($keys);

        foreach ($models as $i => $item) {
            if (isset($products[$item['id']])) {
                $product = $products[$item['id']];
                $productAdditional = [
                    'price' => $product['price'],
                    'seo_title' => $product['seo_title'],
                    'keywords' => $product['keywords'],
                ];
            } else {
                $productAdditional = [
                    'seo_title' => $item['title'],
                    'keywords' => ''
                ];
            }
            $models[$i] = array_merge($models[$i], $productAdditional);
        }

        return $models;
    }

    /**
     * @param int[] $ids
     * @return array|\yii\db\ActiveRecord[]
     */
    protected function getProducts($ids)
    {
        return Product::find()
            ->andWhere(['product_id' => $ids, 'shop_id' => $this->shopId])
            ->asArray()
            ->indexBy('product_id')
            ->all();
    }

}
