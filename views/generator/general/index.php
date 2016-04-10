<?php

use yii\helpers\ArrayHelper;
use yii\bootstrap\Html;
use yii\bootstrap\ActiveForm;
use app\models\forms\GeneralSettingsForm;

/** @var array $brands */
/** @var GeneralSettingsForm $model */

$form = ActiveForm::begin();

$this->title = 'Настройка генератора';
?>

<div class="row">
    <div class="col-sm-3">
            <?= $form->field($model, 'brandsList', [
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
                        <?= $form->field($model, 'price_from', ['template' => "{input}\n{error}"])->textInput()?>
                    </div>
                    <div class="col-sm-1">до</div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'price_to', ['template' => "{input}\n{error}"])->textInput()?>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <?= Html::button('Обновить', [
                    'class' => 'btn btn-primary yandex-update',
                    'data-shop-id' => $model->shop_id
                ])?>
                <div>
                    asdf
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success'])?>
            </div>
        </div>
    </div>
</div>

<? $form->end()?>

<?php

\app\assets\GeneralAsset::register($this);
