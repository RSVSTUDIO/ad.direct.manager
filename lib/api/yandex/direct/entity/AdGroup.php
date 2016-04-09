<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 27.03.16
 * Time: 15:40
 */

namespace app\lib\yandex\direct\entity;

class AdGroup extends BaseEntity
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var int
     */
    public $campaignId;

    /**
     * @var array
     */
    public $regionIds;

    /**
     * @var array
     */
    public $negativeKeywords;

    /**
     * @var string
     */
    public $trackingParams;

    /**
     * @var string
     */
    public $status;

    /**
     * @var string
     */
    public $type;
}
