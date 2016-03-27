<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 27.03.16
 * Time: 9:05
 */

namespace app\controllers;

use app\models\CampaignSearch;

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
}