<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%products}}".
 *
 * @property integer $id
 * @property integer $shop_id
 * @property integer $product_id
 * @property string $title
 * @property string $seo_title
 * @property string $keywords
 *
 * @property Shop $shop
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%products}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_id', 'product_id', 'title', 'seo_title', 'keywords'], 'required'],
            [['shop_id', 'product_id'], 'integer'],
            [['keywords'], 'string'],
            [['title'], 'string', 'max' => 500],
            [['seo_title'], 'string', 'max' => 33]
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
            'product_id' => 'Product ID',
            'title' => 'Title',
            'seo_title' => 'Seo Title',
            'keywords' => 'Keywords',
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
