<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Template */

$this->title = 'Обновить шаблон';
$this->params['breadcrumbs'][] = ['label' => 'Шаблоны объявлений', 'url' => ['index', 'shopId' => Yii::$app->request->get('shopId')]];
$this->params['breadcrumbs'][] = 'Обновление';
?>
<div class="template-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
