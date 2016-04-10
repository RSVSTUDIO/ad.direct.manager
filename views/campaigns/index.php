<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\YandexCampaignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список кампаний';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="yandex-campaign-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<!--    <p>-->
<!--        --><?//= Html::a('Create Yandex Campaign', ['create'], ['class' => 'btn btn-success']) ?>
<!--    </p>-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'shop.name',
            'title',
            'yandex_id',
            [
                'label' => 'Минус слова',
                'value' => function (\app\models\YandexCampaign $model) {
                    $words = \yii\helpers\ArrayHelper::getValue($model, 'yandexData.NegativeKeywords.Items');

                    return implode(', ', $words);
                }
            ],
            [
                'label' => 'Статус',
                'value' => function (\app\models\YandexCampaign $model) {
                    return \yii\helpers\ArrayHelper::getValue($model, 'yandexData.Status') . '(' .
                        \yii\helpers\ArrayHelper::getValue($model, 'yandexData.StatusClarification') . ')';
                }
            ],
            [
                'label' => 'Дневной бюджет',
                'value' => function (\app\models\YandexCampaign $model) {
                    return \yii\helpers\ArrayHelper::getValue($model, 'yandexData.DailyBudget.Amount') / 1000000;
                }
            ],
            [
                'label' => 'Валюта',
                'value' => function (\app\models\YandexCampaign $model) {
                    return \yii\helpers\ArrayHelper::getValue($model, 'yandexData.Currency');
                }
            ],
            'products_count',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}'
            ],
        ],
    ]); ?>

</div>
