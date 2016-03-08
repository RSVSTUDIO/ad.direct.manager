<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 08.03.16
 * Time: 17:09
 */

namespace app\components\grid;

use yii\bootstrap\Html;

class ActionColumn extends \yii\grid\ActionColumn
{
    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url, $model, $key) {
                $options = array_merge([
                    'title' => \Yii::t('yii', 'Update'),
                    'aria-label' => \Yii::t('yii', 'Update'),
                    'data-pjax' => '0',
                ], $this->buttonOptions);
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model, $key) {
                $options = array_merge([
                    'title' => \Yii::t('yii', 'Delete'),
                    'aria-label' => \Yii::t('yii', 'Delete'),
                    'data-confirm' => \Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ], $this->buttonOptions);
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
            };
        }
    }
}