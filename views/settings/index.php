<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

?>

<div class="setting-form">
    <div class="row">
        <div class="col-sm-12">
            <? $form = ActiveForm::begin([
                'options' => [
                    'class' => 'form-horizontal'
                ]

            ])?>

            <?= $form->field($model, 'negativeKeywords')->textarea()?>

            <?=Html::submitButton('Сохранить', ['class' => 'btn btn-success'])?>

            <? $form->end()?>
        </div>
    </div>
</div>

