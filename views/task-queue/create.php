<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\TaskQueue */

$this->title = 'Create Task Queue';
$this->params['breadcrumbs'][] = ['label' => 'Task Queues', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-queue-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
