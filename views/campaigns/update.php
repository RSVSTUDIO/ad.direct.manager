<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\YandexCampaign */

$this->title = 'Обновить: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Список кампаний', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="yandex-campaign-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
