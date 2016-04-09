<?php

namespace app\models;

use Yii;

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
 */
class YandexUpdateLog extends \yii\db\ActiveRecord
{
    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';

    const OPERATION_CREATE = 'create';
    const OPERATION_UPDATE = 'update';
    CONST OPERATION_REMOVE = 'remove';
    
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
            'task_id' => 'Task ID',
            'shop_id' => 'Shop ID',
            'entity_type' => 'Entity Type',
            'entity_id' => 'Entity ID',
            'created_at' => 'Created At',
            'status' => 'Status',
            'message' => 'Message',
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
