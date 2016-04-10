<?php

return [
    'class' => \yii\db\Connection::className(),
    'dsn' => 'mysql:host=localhost;dbname=seo_admin',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
    'on afterOpen' => function ($event) {
        $event->sender->createCommand("SET time_zone = '+3:00'")->execute();
    }
];
