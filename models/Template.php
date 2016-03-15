<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "templates".
 *
 * @property integer $id
 * @property integer $shop_id
 * @property string $title
 * @property string $message
 */
class Template extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'templates';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_id', 'title', 'message'], 'required'],
            [['shop_id'], 'integer'],
            [['title', 'message'], 'string', 'max' => 150]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'shop_id' => 'Магазин',
            'title' => 'Заголовок',
            'message' => 'Объявление',
        ];
    }
}
