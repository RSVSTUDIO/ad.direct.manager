<?php
use app\assets\SecurityAsset;
use yii\bootstrap\ActiveForm;
use app\models\LoginForm;
use yii\bootstrap\Html;

/**
 * @var LoginForm $model
 */

$this->title = 'Авторизация';

SecurityAsset::register($this);

/** @var ActiveForm $form */
$form = ActiveForm::begin([
    'options' => [
        'class' => 'form-signin'
    ]
]);



?>

    <h2 class="form-signin-heading">Авторизация</h2>
    <?= Html::label('Логин', 'inputLogin', ['class' => 'sr-only']) ?>
    <?= Html::activeInput('text', $model, 'login',
        ['class' => 'form-control login', 'placeholder' => 'Логин', 'required' => true, 'autofocus' => true]) ?>
    <?= Html::label('Пароль', 'inputPassword', ['class' => 'sr-only']) ?>
    <?= Html::activeInput('password', $model, 'password', ['class' => 'form-control', 'placeholder' => 'Пароль']) ?>

<? if ($model->hasErrors()):?>
    <? foreach ($model->errors as $error):?>
        <p class="text-danger"><?= reset($error) ?></p>
    <? endforeach?>
<? endif?>

    <?= $form->field($model, 'rememberMe')->checkbox()->label('Запомнить') ?>

    <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>


<?php

$form->end();
