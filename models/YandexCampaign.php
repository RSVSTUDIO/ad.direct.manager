<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "yandex_campaign".
 *
 * @property integer $id
 * @property integer $shop_id
 * @property integer $brand_id
 * @property string $title
 * @property integer $yandex_id
 * @property int $products_count
 *
 * @property Shop $shop
 */
class YandexCampaign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yandex_campaign';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_id', 'brand_id', 'title', 'yandex_id'], 'required'],
            [['shop_id', 'brand_id', 'yandex_id'], 'integer'],
            ['products_count', 'integer'],
            [['title'], 'string', 'max' => 255]
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
            'brand_id' => 'Brand ID',
            'title' => 'Title',
            'yandex_id' => 'Yandex ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['id' => 'shop_id']);
    }

    /**
     * Обновление количества товаров в кампании
     *
     * @param $shopId
     * @param $brandId
     * @return int
     */
    public static function incrementProductsCount($shopId, $brandId)
    {
        return self::updateAllCounters(['products_count' => 1], ['shop_id' => $shopId, 'brand_id' => $brandId]);
    }

    /**
     * @param $shopId
     * @param $brandId
     * @return YandexCampaign
     */
    public static function getCampaign($shopId, $brandId)
    {
        return self::find()->andWhere([
                'shop_id' => $shopId,
                'brand_id' => $brandId
            ])
            ->orderBy(['id' => SORT_DESC])
            ->one();
    }
}
