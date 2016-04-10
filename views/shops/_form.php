<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Shop */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shop-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'brand_api_url')->textInput() ?>

    <?= $form->field($model, 'product_api_url')->textInput() ?>

    <?= $form->field($model, 'api_secret_key')->textInput() ?>

    <?= $form->field($model, 'yandex_application_id')->textInput() ?>

    <?= $form->field($model, 'yandex_secret')->textInput()?>

    <?= $form->field($model, 'yandex_access_token')->textInput()?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
