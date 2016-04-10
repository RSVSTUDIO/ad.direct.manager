<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 12.03.16
 * Time: 19:00
 */

namespace app\controllers\generator;

use app\lib\api\shop\gateways\BrandsGateway;
use app\controllers\BaseController;
use app\models\forms\GeneratorSettingsForm;
use app\models\Shop;
use yii\web\BadRequestHttpException;
use yii\web\Response;

class GeneralController extends BaseController
{
    public function actionIndex($shopId)
    {
        /** @var Shop $shop */
        $shop = Shop::findOne($shopId);
        if (!$shop) {
            throw new BadRequestHttpException('Shop not found.');
        }

        $brandsApiGateway = new BrandsGateway($shop->brand_api_url, $shop->api_secret_key);

        $model = GeneratorSettingsForm::find()->andWhere(['shop_id' => $shopId])->one();
        if (!$model) {
            $model = new GeneratorSettingsForm([
                'shop_id' => $shopId
            ]);
        }

        $postData = $this->request->post();

        if ($model->load($postData) && $model->save()) {
            //success save
        }

        return $this->render('index', [
            'brands' => $brandsApiGateway->getBrandsList(),
            'model' => $model
        ]);
    }

    public function actionStartUpdate()
    {
        $this->response->format = Response::FORMAT_JSON;
    }
}