<?php

namespace app\models;

use app\components\api\shop\models\ApiProduct;
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
 * @property float $price
 * @property bool $is_available
 * @property int $yandex_campaign_id
 * @property int $yandex_adgroup_id
 * @property int $yandex_ad_id
 *
 * @property Shop $shop
 * @property YandexCampaign $yandexCampaign
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @var ApiProduct
     */
    protected $shopProduct;
    
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
            [['shop_id', 'product_id'], 'required'],
            [['shop_id', 'product_id'], 'integer'],
            [['keywords'], 'string'],
            [['title'], 'string'],
            [['seo_title'], 'string'],
            ['price', 'number'],
            [['yandex_campaign_id', 'yandex_adgroup_id', 'yandex_ad_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ИД',
            'shop_id' => 'ИД магазина',
            'product_id' => 'Товар',
            'title' => 'Название',
            'seo_title' => 'Название директа',
            'keywords' => 'Ключевые слова',
            'price' => 'Цена'
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
     * @return \yii\db\ActiveQuery
     */
    public function getYandexCampaign()
    {
        return $this->hasOne(YandexCampaign::className(), ['id' => 'yandex_campaign_id']);
    }
}
