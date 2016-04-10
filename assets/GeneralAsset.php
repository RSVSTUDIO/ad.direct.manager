<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 10.04.16
 * Time: 9:40
 */

namespace app\assets;

use yii\web\AssetBundle;

class GeneralAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/resource';
    
    public $js = [
        'js/generalController.js'
    ];
}