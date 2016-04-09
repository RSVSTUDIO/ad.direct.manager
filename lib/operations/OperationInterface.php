<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 09.04.16
 * Time: 14:24
 */

namespace app\lib\operations;

interface OperationInterface
{
    /**
     * @param array $context
     * @return mixed
     */
    public function execute($context = []);
}
