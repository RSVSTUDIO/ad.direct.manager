<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\models\YandexUpdateLog;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel \app\models\search\UpdateLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Change log';

$this->params['breadcrumbs'][] = ['label' => 'Список задач', 'url' => ['/task-queue']];
$this->params['breadcrumbs'][] = 'Подробно';

?>
<div class="task-queue-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'shop.name'
            ],
            'entity_type',
            [
                'label' => 'Сущность',
                'attribute' => 'entity_id',
                'value' => function (\app\models\YandexUpdateLog $model) {
                    if ($model->entity_type == YandexUpdateLog::ENTITY_PRODUCT) {
                        return ArrayHelper::getValue($model->product, 'title');
                    } else {
                        return ArrayHelper::getValue($model->campaign, 'title');
                    }
                }
            ],
            [
                'label' => 'yandex id',
                'value' => function (YandexUpdateLog $model) {
                    if ($model->entity_type == YandexUpdateLog::ENTITY_PRODUCT) {
                        return ArrayHelper::getValue($model->product, 'yandex_ad_id');
                    } else {
                        return ArrayHelper::getValue($model->campaign, 'yandex_id');
                    }
                }
            ],
            'created_at',
            'operation',
            'status',
            'message'
        ],
    ]); ?>

</div>
