<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 12.03.16
 * Time: 19:00
 */

namespace app\controllers\generator;

use app\components\api\shop\gateways\BrandsGateway;
use app\controllers\BaseController;
use app\models\forms\GeneralSettingsForm;
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
        $form = new GeneralSettingsForm();

        return $this->render('index', [
            'brands' => $brandsApiGateway->getBrandsList(),
            'model' => $form
        ]);
    }

    public function actionUpdateProductAvailable()
    {
        $this->response->format = Response::FORMAT_JSON;
        
        
    }
}