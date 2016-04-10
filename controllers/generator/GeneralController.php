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
use app\lib\operations\YandexUpdateOperation;
use app\models\forms\GeneratorSettingsForm;
use app\models\Shop;
use app\models\TaskQueue;
use yii\helpers\Url;
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
            return $this->redirect(Url::current());
        }

        return $this->render('index', [
            'brands' => $brandsApiGateway->getBrandsList(),
            'model' => $model
        ]);
    }

    /**
     * Добавление задачи на обновление
     * @return array
     */
    public function actionStartUpdate()
    {
        $this->response->format = Response::FORMAT_JSON;

        $brandIds = array_map('intval', $this->request->post('brandIds', []));
        $shopId = $this->request->post('shopId');

        if (TaskQueue::hasReadyTasks($shopId)) {
            return [
                'message' => 'Обновление уже запущено'
            ];
        }

        $context = [
            'brandIds' => $brandIds,
            'shopId' => $shopId,
            'priceFrom' => (float) $this->request->post('priceFrom'),
            'priceTo' => (float) $this->request->post('priceTo')
        ];

        $task = TaskQueue::createNewTask($shopId, YandexUpdateOperation::OPERATION_YANDEX_UPDATE, $context);

        if ($task->hasErrors()) {
            $message = 'Возникли ошибки: ' . reset($task->getFirstErrors());
        } else {
            $message = 'Задача на обновление успешно создана';
        }

        return [
            'message' => $message
        ];
    }
}