<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "yandex_oauth".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $shop_id
 * @property string $access_token
 *
 * @property Shop $shop
 * @property User $user
 */
class YandexOauth extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yandex_oauth';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'shop_id', 'access_token'], 'required'],
            [['user_id', 'shop_id'], 'integer'],
            [['access_token'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'shop_id' => 'Shop ID',
            'access_token' => 'Access Token',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Возвращает токен авторизации
     *
     * @param int $shopId
     * @param int $userId
     * @return mixed
     */
    public static function getTokenFor($shopId, $userId)
    {
        $oauthToken = self::find()->where(['shop_id' => $shopId, 'user_id' => $userId])->one();
        return ArrayHelper::getValue($oauthToken, 'token');
    }
}
