<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 27.03.16
 * Time: 9:05
 */

namespace app\controllers;

use app\lib\yandex\direct\Connection;
use app\lib\yandex\direct\entity\Campaign;
use app\lib\yandex\direct\mappers\CampaignMapper;
use app\models\CampaignSearch;
use app\models\forms\CampaignForm;
use app\models\YandexOauth;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class CampaignController extends BaseController
{
    public function actionIndex($shopId)
    {
        $campaignSearch = new CampaignSearch();
        
        $provider = $campaignSearch->search([
            'shopId' => $shopId,
            'userId' => $this->getUser()->getId()
        ]);

        return $this->render('index', [
            'provider' => $provider,
            'searchModel' => $campaignSearch
        ]);
    }
    
    public function actionUpdate($id, $shopId)
    {
        $model = $this->findModel($id, $shopId);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(Url::to(['/campaign', 'shopId' => $shopId]));
        }
        
        return $this->render('update', [
            'model' => $model
        ]);
    }

    /**
     * @param $id
     * @param $shopId
     * @return CampaignForm
     * @throws NotFoundHttpException
     */
    public function findModel($id, $shopId)
    {
        $token = YandexOauth::getTokenFor($shopId);
        $connection = new Connection($token);
        $campaignMapper = new CampaignMapper($connection);
        /** @var Campaign $campaignEntity */
        $campaignEntity = $campaignMapper->findById($id);

        if (!$campaignEntity) {
            throw new NotFoundHttpException();
        }

        $campaignForm = new CampaignForm([
            'id' => $id,
            'name' => $campaignEntity->name,
            'currency' => $campaignEntity->currency,
            'clientInfo' => $campaignEntity->clientInfo,
            'shopId' => $shopId
        ]);

        return $campaignForm;
    }
}