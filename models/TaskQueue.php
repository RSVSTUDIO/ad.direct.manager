<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task_queue".
 *
 * @property integer $id
 * @property string $created_at
 * @property string $status
 * @property string $operation
 * @property string $completed_at
 * @property string $context
 * @property string $error
 * @property int $shop_id
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
            [['created_at', 'completed_at'], 'safe'],
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
     * @return array|null|\yii\db\ActiveRecord
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
}
