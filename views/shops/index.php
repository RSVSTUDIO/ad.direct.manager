<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ShopSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список магазинов';
?>
<div class="shop-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить магазин', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
    //    'filterModel' => $searchModel,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'brand_api_url:ntext',
            'product_api_url:ntext',
            [
                'label' => '',
                'value' => function (\app\models\Shop $model) {
                    return "<div class=\"dropdown\">
                              <a class=\"dropdown-toggle\" href=\"#\" role=\"button\" data-toggle=\"dropdown\">Настройки
                              <span class=\"caret\"></span></a>
                              <ul class=\"dropdown-menu\">
                                <li>" . Html::a('Настройка генератора', Url::to(['/generator/general', 'shopId' => $model->id])) ."</li>
                                <li>" . Html::a('Ключевые слова', Url::to(['/generator/keywords', 'shopId' => $model->id])) ."</li>
                                <li>" . Html::a('Шаблоны объявлений', Url::to(['/generator/templates', 'shopId' => $model->id])) ."</li>
                              </ul>
                            </div>";
                },
                'format' => 'raw'
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}'
            ],
        ],
    ]); ?>

</div>
