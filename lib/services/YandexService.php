<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 09.04.16
 * Time: 22:02
 */

namespace app\lib\services;

use app\lib\api\yandex\direct\exceptions\YandexException;
use app\lib\api\yandex\direct\query\ChangeResult;

class YandexService
{
    /**
     * @param ChangeResult $result
     * @throws YandexException
     */
    public function throwExceptionFromResult(ChangeResult $result)
    {
        $errorInfo = $result->firstError();
        $errorMsg = $errorInfo['Code'] . ':' . $errorInfo['Message'];
        if (!empty($errorInfo['Details'])) {
            $errorMsg .= ': ' . $errorInfo['Details'];
        }

        throw new YandexException($errorMsg, $errorInfo['Code']);
    }
}
