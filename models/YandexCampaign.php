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
    const MAX_CAMPAIGN_PRODUCTS = 999;

    /**
     * @var array
     */
    public $yandexData = [];

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
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'shop_id' => 'Магазин',
            'brand_id' => 'Бренд',
            'title' => 'Название кампании',
            'yandex_id' => 'Yandex ID',
            'products_count' => 'Товаров в кампании',
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
     * @return int
     */
    public function incrementProductsCount()
    {
        return self::updateAllCounters(['products_count' => 1], ['id' => $this->id]);
    }

    /**
     * Уменьшить счетчик кол-ва товаров в кампании
     * @return int
     */
    public function decrementProductsCount()
    {
        return self::updateAllCounters(['products_count' => -1], ['id' => $this->id]);
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
            ->andWhere('products_count < ' . self::MAX_CAMPAIGN_PRODUCTS)
            ->one();
    }
}
