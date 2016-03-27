<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 27.03.16
 * Time: 15:45
 */

namespace app\lib\yandex\direct\entity;


class Ad extends BaseEntity
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $campaignId;

    /**
     * @var int
     */
    public $adGroupId;

    /**
     * @var string
     */
    public $status;

    /**
     * @var string
     */
    public $statusClarification;

    /**
     * @var string
     */
    public $state;

    /**
     * @var string
     */
    public $adCategories;

    /**
     * @var string
     */
    public $ageLabel;

    /**
     * @var string
     */
    public $type;

    /**
     * @var \app\lib\yandex\direct\entity\ad\TextAdGet
     */
    public $textAd;
}