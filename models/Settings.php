<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "settings".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 */
class Settings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'value'], 'required'],
            [['value'], 'string'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value' => 'Value',
        ];
    }

    /**
     * Вернуть значение настройки
     *
     * @param $name
     * @param null $default
     * @return mixed|null
     */
    public static function getValue($name, $default = null)
    {
        $setting = self::find()->andWhere(['name' => $name])->one();

        if ($setting) {
            return $setting->value;
        } else {
            return $default;
        }
    }

    /**
     * Сохранение значения
     *
     * @param string $name
     * @param mixed $value
     * @return bool
     */
    public static function saveValue($name, $value)
    {
        $setting = self::find()->andWhere(['name' => $name])->one();

        if (!$setting) {
            $setting = new Settings([
                'name' => $name
            ]);
        }

        $setting->value = $value;

        return $setting->save();
    }
}
