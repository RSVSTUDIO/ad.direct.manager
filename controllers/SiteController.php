<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\filters\VerbFilter;

class SiteController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['login', 'logout'],
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return mixed|\yii\web\User
     */
    protected function getUser()
    {
        return Yii::$app->user;
    }

    /**
     * @inheritDoc
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if ($this->getUser()->isGuest && Yii::$app->controller->id != 'security') {
            return $this->redirect(Url::to(['/login']));
        }

        return true;
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

//    public function actions()
//    {
//        return [
//            'error' => [
//                'class' => 'yii\web\ErrorAction',
//            ],
//        ];
//    }

    /**
     * @return string
     */
    public function actionError()
    {
        if (Yii::$app->user->isGuest) {
            header('Location: /login');
            die;
        } else {
            $this->layout = 'simple';
            $exception = Yii::$app->errorHandler->exception;
            if ($exception !== null) {
                return $this->render('error', ['message' => $exception->getMessage()]);
            }
        }
    }

}
