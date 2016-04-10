<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\YandexCampaign */

$this->title = 'Create Yandex Campaign';
$this->params['breadcrumbs'][] = ['label' => 'Yandex Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yandex-campaign-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
