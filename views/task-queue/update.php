<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaskQueue */

$this->title = 'Update Task Queue: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Task Queues', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="task-queue-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
