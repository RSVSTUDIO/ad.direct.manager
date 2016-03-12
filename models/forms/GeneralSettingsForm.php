<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 12.03.16
 * Time: 20:34
 */

namespace app\models\forms;

use yii\base\Model;

class GeneralSettingsForm extends Model
{
    /**
     * Список выбранных брендов
     * @var array
     */
    public $brands = [];

    /**
     * @var float
     */
    public $priceFrom;

    /**
     * @var float
     */
    public $priceTo;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['brands'], 'safe'],
            [['priceFrom', 'priceTo'], 'number']
        ];
    }
}
