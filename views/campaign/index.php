<?php

use app\lib\yandex\direct\entity\Campaign;
use yii\grid\GridView;

/**
 * @var \yii\web\View $this
 * @var \app\models\CampaignSearch $searchModel
 */

$this->title = 'Список кампаний';

?>

<div class="campaign-index">
    <h1><?= \yii\helpers\Html::encode($this->title)?></h1>
</div>


<?= GridView::widget([
    'dataProvider' => $provider,
    'columns' => [
        'id',
        'name',
        'type',
        'status',
        'state',
        'statusPayment',
        'clientInfo',
        'startDate',
        'timeZone',
        [
            'class' => '\yii\grid\ActionColumn',
            'template' => '{update}',
            'buttons' => [
                'update' => function ($url, $model, $key) use ($searchModel) {
                    return \yii\helpers\Html::a(
                        '<span class="glyphicon glyphicon-pencil"></span>',
                        \yii\helpers\Url::to(['/campaign/update', 'shopId' => $searchModel->shopId, 'id' => $model->id]),
                        [

                        ]
                    );
                }
            ]
        ]
    ]
])?>