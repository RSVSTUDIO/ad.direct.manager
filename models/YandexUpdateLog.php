<?php

namespace app\models;

use app\lib\api\yandex\direct\entity\Campaign;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "yandex_update_log".
 *
 * @property integer $id
 * @property integer $task_id
 * @property integer $shop_id
 * @property string $entity_type
 * @property integer $entity_id
 * @property string $created_at
 * @property string $status
 * @property string $message
 * @property string $operation
 *
 * @property Shop $shop
 * @property Product $product
 * @property Campaign $campaign
 */
class YandexUpdateLog extends \yii\db\ActiveRecord
{
    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';

    const OPERATION_CREATE = 'create';
    const OPERATION_UPDATE = 'update';
    const OPERATION_REMOVE = 'remove';
    const OPERATION_API_LOAD = 'load_from_api';

    const ENTITY_PRODUCT = 'product';
    const ENTITY_CAMPAIGN = 'campaign';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yandex_update_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'shop_id', 'entity_type', 'entity_id', 'status'], 'required'],
            [['task_id', 'shop_id', 'entity_id'], 'integer'],
            [['created_at'], 'safe'],
            [['entity_type', 'status'], 'string', 'max' => 50],
            [['message', 'operation'], 'string', 'max' => 300]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Задача',
            'shop_id' => 'Магазин',
            'entity_type' => 'Тип сущности',
            'entity_id' => 'Сущность',
            'created_at' => 'Дата создания',
            'status' => 'Статус',
            'message' => 'Сообщение',
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
     * @return ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'entity_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCampaign()
    {
        return $this->hasOne(YandexCampaign::className(), ['id' => 'entity_id']);
    }
}
