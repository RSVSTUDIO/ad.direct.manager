<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 27.03.16
 * Time: 19:11
 */

namespace app\commands;

use app\lib\operations\OperationInterface;
use app\models\TaskQueue;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\console\Controller;
use yii\helpers\Inflector;

class TaskRunnerController extends Controller
{

    public function actionIndex()
    {
        while (null !== ($task = TaskQueue::getNextTaskForRun())) {
            /** @var OperationInterface $operation */
            $operation = $this->createOperationByTask($task);
            try {
                $task->markRun();
                $operation->execute();
                $task->markCompleted();
            } catch (Exception $e) {
                $task->markError($e->getMessage());
            } catch (ErrorException $e) {
                $task->markError($e->getMessage());
            }
        }
    }

    /**
     * Возвращает операцию для запуска
     *
     * @param TaskQueue $task
     * @return OperationInterface
     * @throws Exception
     */
    protected function createOperationByTask(TaskQueue $task)
    {
        $operation = $task->operation;
        $operation = Inflector::camelize($operation);
        $operationClass = 'app\lib\operations\\' . $operation . 'Operation';

        if (!class_exists($operationClass)) {
            throw new Exception("Operation - '$operation' not found.");
        }

        return new $operationClass($task);
    }

    protected function getStub()
    {
        return [
            'context' => [
                'shopId' => 1,
                'userId' => 1,
            ],
            'operation' => 'updateAvailability'
        ];
    }

}