<?php

use yii\helpers\ArrayHelper;
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use app\models\forms\GeneralSettingsForm;

/** @var array $brands */
/** @var GeneralSettingsForm $model */

$form = ActiveForm::begin();
?>

<div class="row">
    <div class="col-sm-3">
            <?= $form->field($model, 'brands', [
                'template' => "{label}\n{beginWrapper}\n<div style=\"height: 500px; overflow: hidden; overflow-y: scroll\">{input}</div>\n{error}\n{endWrapper}\n{hint}"
            ])->checkboxList(ArrayHelper::map($brands, 'id', 'title'))->label('Бренды')?>
    </div>
    <div class="col-sm-9">
        <div class="row">
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <label class="control-label">Цена</label>
                    </div>
                    <div class="col-sm-1" style="text-align: center">от</div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'priceFrom', ['template' => "{input}\n{error}"])->textInput()?>
                    </div>
                    <div class="col-sm-1">до</div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'priceTo', ['template' => "{input}\n{error}"])->textInput()?>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <a class="btn btn-info">Сгенерировать файл</a>
            </div>
            <div class="col-sm-3">
                <a class="btn btn-info">Обновить наличие</a>
            </div>
            <div class="col-sm-2">
                <a class="btn btn-info">Обновить цену</a>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <a class="btn btn-info">Создать, обновить компанию</a>
    </div>
    <div class="col-sm-3">
        <a class="btn btn-success">Сохранить</a>
    </div>
</div>

<? $form->end()?>
