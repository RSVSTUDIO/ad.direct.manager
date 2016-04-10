<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 10.04.16
 * Time: 17:25
 */

namespace app\models\forms;

use app\models\Settings;
use yii\base\Model;

class SettingForm extends Model
{
    /**
     * @var string
     */
    public $negativeKeywords;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [['negativeKeywords'], 'string']
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributeLabels()
    {
        return [
            'negativeKeywords' => 'Минус слова'
        ];
    }

    /**
     * @inheritDoc
     */
    public function init()
    {
        foreach ($this->attributes() as $attribute) {
            $this->$attribute = Settings::getValue($attribute);
        }
    }

    /**
     * @return bool
     */
    public function save()
    {
        if (!$this->validate()) {
            return false;
        }

        foreach ($this->getAttributes() as $attribute => $value) {
            Settings::saveValue($attribute, $value);
        }

        return true;
    }
}
