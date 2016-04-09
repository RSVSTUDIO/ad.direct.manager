<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 03.04.16
 * Time: 14:59
 */

namespace app\lib\api\shop\models;

use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

/**
 * Class ApiProduct
 * Обертка над возвращаемыми апи товарами
 * @package app\lib\api\shop\models
 */
class ApiProduct extends Model
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var array
     */
    public $categories;

    /**
     * @var array
     */
    public $brand;

    /**
     * @var string
     */
    public $href;

    /**
     * @var string
     */
    public $seoTitle;

    /**
     * @var string
     */
    public $image;

    /**
     * @var string
     */
    public $title;

    /**
     * @var bool
     */
    public $isAvailable;

    /**
     * @var float
     */
    public $price;

    /**
     * ApiProduct constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $result = [];
        foreach ($config as $key => $value) {
            $key = Inflector::camelize($key);
            $key = strtolower(substr($key, 0, 1)) . substr($key, 1);
            $result[$key] = $value;
        }
        
        parent::__construct($result);
    }

    /**
     * @return int
     */
    public function getBrandId()
    {
        return ArrayHelper::getValue($this->brand, 'id');
    }

    /**
     * @return string
     */
    public function getBrandTitle()
    {
        return ArrayHelper::getValue($this->brand, 'title');
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return ArrayHelper::getValue($this->categories, '0.title');
    }
}
