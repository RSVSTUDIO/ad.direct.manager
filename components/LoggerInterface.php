<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 09.04.16
 * Time: 17:47
 */

namespace app\components;

interface LoggerInterface
{
    /**
     * @param string $msg
     * @return mixed
     */
    public function log($msg);
}
