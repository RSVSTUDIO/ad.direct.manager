<?php
use yii\web\View;

/**
 * @var View $this
 */

$this->title = 'Обновление кампании';

?>

<div class="campaign-update">
    <h2><?= \yii\helpers\Html::encode($this->title)?></h2>
    <?= $this->render('_form', ['model' => $model])?>
</div>
