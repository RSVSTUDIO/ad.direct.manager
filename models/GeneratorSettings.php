<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "generator_settings".
 *
 * @property integer $id
 * @property integer $shop_id
 * @property double $price_from
 * @property double $price_to
 * @property string $brands
 *
 * @property Shop $shop
 */
class GeneratorSettings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'generator_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_id'], 'integer'],
            [['price_from', 'price_to'], 'number'],
            [['brands'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shop_id' => 'Shop ID',
            'price_from' => 'Price From',
            'price_to' => 'Price To',
            'brands' => 'Brands',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['id' => 'shop_id']);
    }
}
