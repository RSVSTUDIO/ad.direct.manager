<?php

use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;
use app\models\search\ProductsApiSearch;
use app\lib\provider\ProductsApiDataProvider;
use yii\bootstrap\ActiveForm;
use yii\grid\GridView;
use app\assets\KeywordsAsset;
use yii\widgets\Pjax;
use kartik\editable\Editable;

/** @var \yii\web\View $this */
/** @var ProductsApiSearch $searchModel */
/** @var ProductsApiDataProvider $dataProvider */
/** @var array $brands */

$this->title = 'Ключевые слова и заголовки';

Pjax::begin(['id' => 'keywords-container-pjax']);
$form = ActiveForm::begin([
    'id' => 'keywords-filter-form',
    'method' => 'get',
    'action' => \yii\helpers\Url::to(['/generator/keywords', 'shopId' => $searchModel->shopId]),
    'options' => [
        'data-pjax' => '1'
    ]
]);

?>


<div class="row">
    <div class="col-sm-3">
        <?= $form->field($searchModel, 'brandId')
            ->dropDownList(ArrayHelper::map($brands, 'id', 'title'), ['prompt' => 'Выберите бренд'])
            ->label('Бренд')
        ?>
    </div>
    <div class="col-sm-2">
        <div style="margin-top: 30px">
            <?= $form->field($searchModel, 'onlyActive')->checkbox()->label('Только активные')?>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="pull-right" style="margin-top: 15px;">
            <a href="#" class="btn btn-success save-products">Сохранить</a>
        </div>
    </div>
</div>
<? $form->end()?>

<div class="row">
    <div class="col-sm-12">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'label' => 'Название товара',
                    'attribute' => 'title'
                ],
                [
                    'label' => 'Название для директа',
                    'attribute' => 'seo_title',
                    'value' => function ($model) {
                        echo Html::hiddenInput("Products[{$model['id']}][title]", $model['title']);
                        echo Html::hiddenInput("Products[{$model['id']}][brand_id]", $model['brand']['id']);
                        echo Html::hiddenInput("Products[{$model['id']}][is_available]", $model['is_available']);
                        return Html::input('text', "Products[{$model['id']}][seo_title]", $model['seo_title'], ['class' => 'form-control']);
                    },
                    'format' => 'raw'
                ],
                [
                    'label' => 'Ключевые фразы',
                    'attribute' => 'keywords',
                    'value' => function ($model) {
                        return Html::textarea("Products[{$model['id']}][keywords]", $model['keywords'], ['class' => 'form-control']);
                    },
                    'format' => 'raw'
                ],
                [
                    'label' => 'Цена',
                    'attribute' => 'price',
                    'value' => function ($model) {
                        return Editable::widget([
                            'format' => Editable::FORMAT_LINK,
                            'asPopover' => true,
                            'inputType' => Editable::INPUT_TEXT,
                            'value' => $model['price'],
                            'name' => "Products[{$model['id']}][price]",
                            'pjaxContainerId' => 'keywords-container-pjax',
                            'ajaxSettings' => [
                                'method' => 'post',
                                'url' => \yii\helpers\Url::to(['/generator/keywords/stub'])
                            ],
                            'afterInput' => function ($form) {
                                echo Html::hiddenInput('field', 'price');
                            }
                        ]);
                    },
                    'format' => 'raw'
                ],
                [
                    'label' => 'Наличие',
                    'attribute' => 'is_available',
                    'value' => function ($model) {
                        $class = $model['is_available'] ? "glyphicon glyphicon-plus" : "glyphicon glyphicon-minus";
                        return Html::tag('i', '', ['class' => $class]);
                    },
                    'format' => 'html'
                ]
            ]
        ])?>
    </div>
</div>

<?php
Pjax::end();

KeywordsAsset::register($this);