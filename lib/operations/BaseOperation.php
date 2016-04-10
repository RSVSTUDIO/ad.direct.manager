<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 10.04.16
 * Time: 11:27
 */

namespace app\lib\operations;

use app\models\TaskQueue;

abstract class BaseOperation implements OperationInterface
{
    /**
     * @var TaskQueue
     */
    protected $task;

    /**
     * BaseOperation constructor.
     * @param TaskQueue $task
     */
    public function __construct(TaskQueue $task)
    {
        $this->task = $task;
        $this->init();
    }

    protected function init()
    {
        
    }
}
