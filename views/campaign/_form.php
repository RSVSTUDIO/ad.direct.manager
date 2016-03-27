<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 27.03.16
 * Time: 11:40
 */

?>

<div class="campaign-form">
    <?$form = \yii\bootstrap\ActiveForm::begin()?>

    <?=$form->field($model, 'name')?>

    <?=$form->field($model, 'currency')?>
    <?=$form->field($model, 'clientInfo')?>

    <?= \yii\helpers\Html::submitButton('Обновить', ['class' => 'btn btn-success'])?>
    <?= \yii\helpers\Html::a(
        'Отмена', \yii\helpers\Url::to(['/admin/campaign', 'shopId' => Yii::$app->request->get('shopId')]), [
            'class' => 'btn btn-default'
        ]
    )?>

    <?$form->end()?>
</div>
