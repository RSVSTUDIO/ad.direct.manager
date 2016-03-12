<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 12.03.16
 * Time: 18:49
 */

namespace app\controllers;

use yii\web\Controller;
use yii\web\Request;
use yii\web\Response;

/**
 * Class BaseController
 * @package app\controllers
 *
 * @property Request $request
 * @property Response $response
 */
class BaseController extends Controller
{
    /**
     * @return \yii\console\Request|\yii\web\Request
     */
    public function getRequest()
    {
        return \Yii::$app->request;
    }

    /**
     * @return \yii\console\Response|Response
     */
    public function getResponse()
    {
        return \Yii::$app->response;
    }
}
