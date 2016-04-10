<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task_queue".
 *
 * @property integer $id
 * @property string $created_at
 * @property string $started_at
 * @property string $status
 * @property string $operation
 * @property string $completed_at
 * @property string $context
 * @property string $error
 * @property int $shop_id
 *
 * @property Shop $shop
 */
class TaskQueue extends \yii\db\ActiveRecord
{
    const STATUS_READY = 'ready';
    const STATUS_RUN = 'run';
    const STATUS_ERROR = 'error';
    const STATUS_SUCCESS = 'success';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_queue';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'completed_at', 'started_at'], 'safe'],
            [['context', 'error'], 'string'],
            [['status', 'operation'], 'string', 'max' => 50],
            ['status', 'default', 'value' => self::STATUS_READY],
            ['shop_id', 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'status' => 'Status',
            'operation' => 'Operation',
            'completed_at' => 'Completed At',
            'context' => 'Context',
            'error' => 'Error',
        ];
    }

    /**
     * Имеются ли таски на выполнение
     *
     * @param int $shopId
     * @return bool
     */
    public static function hasReadyTasks($shopId)
    {
        return self::find()
            ->andWhere([
                'shop_id' => $shopId,
                'status' => [self::STATUS_READY, self::STATUS_RUN]
            ])->exists();
    }

    /**
     * Возвращает задачу на выполнение
     *
     * @return $this
     * @throws \yii\db\Exception
     */
    public static function getNextTaskForRun()
    {
        $transaction = Yii::$app->db->beginTransaction();
        $sql = 'SELECT * FROM task_queue WHERE status = :status ORDER BY id ASC FOR UPDATE';
        $task = self::findBySql($sql, [':status' => self::STATUS_READY])->one();
        if ($task) {
            $task->status = self::STATUS_RUN;
            $task->save();
        }
        $transaction->commit();

        return $task;
    }

    /**
     * Создание нового таска
     *
     * @param int $shopId
     * @param string $operation
     * @param array $context
     * @return TaskQueue
     */
    public static function createNewTask($shopId, $operation, array $context = [])
    {
        $task = new TaskQueue([
            'shop_id' => $shopId,
            'status' => self::STATUS_READY,
            'operation' => $operation,
            'context' => json_encode($context)
        ]);

        $task->save();

        return $task;
    }

    /**
     * Помечаем задачу как запущенную
     */
    public function markRun()
    {
        $this->started_at = date(\DateTime::W3C);
        $this->status = self::STATUS_RUN;
        $this->save();
    }

    /**
     * Помечаем задачу как завершенную
     */
    public function markCompleted()
    {
        $this->completed_at = date(\DateTime::W3C);
        $this->status = self::STATUS_SUCCESS;
        $this->save();
    }

    /**
     * Задача завершилась с ошибкой
     * @param string $message
     */
    public function markError($message = '')
    {
        $this->completed_at = date(\DateTime::W3C);
        $this->status = self::STATUS_ERROR;
        $this->error = $message;
        $this->save();
    }

    /**
     * @return mixed
     */
    public function getContext()
    {
        return json_decode($this->context, true);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShop()
    {
        return $this->hasOne(Shop::className(), ['id' => 'shop_id']);
    }

    /**
     * @param int $shopId
     * @return $this
     */
    public static function getLastRunnedFor($shopId)
    {
        return self::find()->andWhere([
            'shop_id' => $shopId,
            'status' => [self::STATUS_SUCCESS, self::STATUS_ERROR]
        ])->orderBy('id DESC')->one();
    }
}
