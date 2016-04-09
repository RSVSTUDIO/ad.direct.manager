<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 09.04.16
 * Time: 17:48
 */

namespace app\components;

class ConsoleLogger implements LoggerInterface
{
    /**
     * @inheritDoc
     */
    public function log($msg)
    {
        printf("%s\t%s\r\n", date('d.m.Y h:i:s'), $msg);
    }
}
