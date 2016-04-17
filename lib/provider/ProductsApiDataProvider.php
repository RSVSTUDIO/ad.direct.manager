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
                    'seo_title' => $product['seo_title'],
                    'keywords' => $product['keywords'],
                    'manual_price' => $product['manual_price']
                ];
            } else {
                $productAdditional = [
                    'seo_title' => '',
                    'keywords' => '',
                    'manual_price' => null
                ];
            }

            if (empty($productAdditional['manual_price'])) {
                $productAdditional['manual_price'] = $item['price'];
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
