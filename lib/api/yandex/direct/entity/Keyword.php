<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 27.03.16
 * Time: 15:53
 */

namespace app\lib\api\yandex\direct\entity;


class Keyword extends BaseEntity
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $adGroupId;

    /**
     * @var string
     */
    public $campaignId;

    /**
     * @var string
     */
    public $keyword;

    /**
     * @var string
     */
    public $userParam1;

    /**
     * @var string
     */
    public $userParam2;

    /**
     * @var int
     */
    public $bid;

    /**
     * @var int
     */
    public $contextBid;

    /**
     * @var string
     */
    public $strategyPriority;

    /**
     * @var string
     */
    public $status;

    /**
     * @var string
     */
    public $state;

    /**
     * @var \app\lib\api\yandex\direct\entity\keyword\Statistics
     */
    public $statisticsSearch;

    /**
     * @var \app\lib\api\yandex\direct\entity\keyword\Statistics
     */
    public $statisticsNetwork;
}