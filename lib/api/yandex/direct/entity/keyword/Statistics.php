<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 27.03.16
 * Time: 15:59
 */

namespace app\lib\api\yandex\direct\entity\keyword;

use app\lib\api\yandex\direct\entity\BaseEntity;

class Statistics extends BaseEntity
{
    /**
     * @var int
     */
    public $clicks;

    /**
     * @var int
     */
    public $impressions;
}