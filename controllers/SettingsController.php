<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 10.04.16
 * Time: 17:21
 */

namespace app\controllers;

use app\models\forms\SettingForm;
use yii\helpers\Url;

class SettingsController extends SiteController
{
    public function actionIndex()
    {
        $settingForm = new SettingForm();

        $postData = $this->request->post();

        if ($settingForm->load($postData) && $settingForm->save()) {
            return $this->redirect(Url::current());
        }

        return $this->render('index', [
            'model' => $settingForm
        ]);
    }
}
