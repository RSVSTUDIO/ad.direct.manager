<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 03.04.16
 * Time: 14:59
 */

namespace app\models;

use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

class ApiProduct extends Model
{
    public $id;

    public $categories;

    public $brand;

    public $href;

    public $seoTitle;
    
    public $image;
    
    public $title;
    
    public $isAvailable;
    
    public $price;
    
    public function __construct(array $config = [])
    {
        $result = [];
        foreach ($config as $key => $value) {
            $result[Inflector::camelize($key)] = $value; 
        }
        
        parent::__construct($result);
    }
    
    public function getBrandId()
    {
        return ArrayHelper::getValue($this->brand, 'id');
    }
}
