<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Template */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Шаблоны объявлений', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="template-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
