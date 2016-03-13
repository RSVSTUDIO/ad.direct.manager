<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 13.03.16
 * Time: 10:12
 */

namespace app\models\forms;

use yii\base\Model;

class KeywordsForm extends Model
{
    /**
     * Выбранный бренд
     * @var int
     */
    public $brand;

    /**
     * @var array
     */
    public $products = [];

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [['brand', 'products'], 'safe']
        ];
    }

}
