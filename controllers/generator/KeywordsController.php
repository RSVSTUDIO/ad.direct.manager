<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 13.03.16
 * Time: 9:53
 */

namespace app\controllers\generator;

use app\controllers\BaseController;
use app\lib\api\shop\gateways\BrandsGateway;
use app\controllers\SiteController;
use app\models\Product;
use app\models\search\ProductsApiSearch;
use app\models\Shop;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class KeywordsController extends BaseController
{
    /**
     * @param int $shopId
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($shopId)
    {
        /** @var Shop $shop */
        $shop = Shop::findOne($shopId);

        if (!$shop) {
            throw new NotFoundHttpException();
        }

        $brandsGateway = new BrandsGateway($shop->brand_api_url, $shop->api_secret_key);
        $searchModel = new ProductsApiSearch();
        $searchModel->shopId = $shopId;

        return $this->render('index', [
            'brands' => $brandsGateway->getBrandsList(),
            'searchModel' => $searchModel,
            'dataProvider' => $searchModel->search($this->request->queryParams)
        ]);
    }

    public function actionStub()
    {
        $this->response->format = Response::FORMAT_JSON;
        if ($this->request->post('hasEditable')) {
            $productInfo = $this->request->post('Products');
            $productInfo = reset($productInfo);
            $manualPrice = $productInfo['manual_price'];
            return ['output' => $manualPrice . ($productInfo['price'] != $manualPrice ? ' (manual)' : '')];
        }

        return ['output' => ''];
    }

    /**
     * Сохранение информации о продуктах
     *
     * @param int $shopId
     * @return array
     */
    public function actionSaveProducts($shopId)
    {
        $this->response->format = Response::FORMAT_JSON;
        $productsData = $this->request->post('Products');
        $productIds = array_keys($productsData);

        /** @var Product[] $products */
        $products = Product::find()
            ->andWhere(['product_id' => $productIds, 'shop_id' => $shopId])
            ->indexBy('product_id')
            ->all();

        foreach ($productsData as $productId => $item) {
            $item['price'] = str_replace(',', '.', $item['price']);
            $item['manual_price'] = str_replace(',', '.', $item['manual_price']);

            //товары без ключевых слов или заголовка не сохраняем
            if (empty($item['keywords']) || empty($item['seo_title']) || empty($item['is_available'])) {
                continue;
            }

            if (isset($products[$productId])) {
                $product = $products[$productId];
                $product->attributes = $item;
                $product->save();
            } else {
                $product = new Product($item);
                $product->shop_id = $shopId;
                $product->product_id = $productId;
                $product->save();
            }
        }

        return ['status' => 'success'];
    }
}