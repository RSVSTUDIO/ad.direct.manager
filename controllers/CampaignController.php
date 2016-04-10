<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 27.03.16
 * Time: 9:05
 */

namespace app\controllers;

use app\lib\api\yandex\direct\Connection;
use app\lib\api\yandex\direct\entity\Campaign;
use app\lib\api\yandex\direct\mappers\CampaignMapper;
use app\models\CampaignSearch;
use app\models\forms\CampaignForm;
use app\models\Shop;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class CampaignController extends SiteController
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
        $shop = Shop::findOne($shopId);
        $token = $shop->yandex_access_token;
        $connection = new Connection($token);
        $campaignMapper = new CampaignMapper($connection);
        
        $campaign = $campaignMapper->findById($id);

        if (!$campaign) {
            throw new NotFoundHttpException();
        }

        $campaignForm = new CampaignForm([
            'id' => $id,
            'name' => $campaign->name,
            'currency' => $campaign->currency,
            'clientInfo' => $campaign->clientInfo,
            'shopId' => $shopId
        ]);

        return $campaignForm;
    }
}