<?php

use app\assets\AppAsset;
use yii\bootstrap\Html;

/* @var $this \yii\web\View */
/* @var string $content */

AppAsset::register($this);

$this->beginPage();
?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?= Html::encode($this->title) ?></title>
        <? $this->head() ?>

    </head>

    <body>
    <? $this->beginBody() ?>


        <div class="container">

            <?= $content ?>

        </div>



    </body>
    <? $this->endBody() ?>
    </html>
<? $this->endPage() ?>