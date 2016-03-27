<?php

use app\lib\yandex\direct\entity\Campaign;
use yii\grid\GridView;

/**
 * @var \yii\web\View $this
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
        'timeZone'
    ]
])?>