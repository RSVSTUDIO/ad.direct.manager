<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\TaskQueueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks';
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
            'created_at',
            'started_at',
            'status',
            'error',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                            Url::to(['/task-queue/details', 'task_id' => $model->id]),
                            [
                                'title' => 'Подробно',
                                'aria-label' => 'Подробно',
                                'data-pjax' => '0',
                            ]
                        );
                    }
                ]
            ],

        ],
    ]); ?>

</div>
