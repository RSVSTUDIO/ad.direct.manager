<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%shops}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $brand_api_url
 * @property string $product_api_url
 * @property string $api_secret_key
 *
 * @property Product[] $products
 */
class Shop extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shops}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'brand_api_url', 'product_api_url'], 'required'],
            [['brand_api_url', 'product_api_url', 'api_secret_key'], 'string'],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название магазина',
            'brand_api_url' => 'Api работы с брендами',
            'product_api_url' => 'Api работы с товарами',
            'api_secret_key' => 'Ключ доступа к api'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['shop_id' => 'id']);
    }
}
