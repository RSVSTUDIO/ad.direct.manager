<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 13.03.16
 * Time: 16:19
 */

namespace app\assets;
use yii\web\AssetBundle;

class KeywordsAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/resource';

    public $js = [
        'js/keywordsController.js'
    ];

    public $depends = [
        'app\assets\AppAsset'
    ];
}
