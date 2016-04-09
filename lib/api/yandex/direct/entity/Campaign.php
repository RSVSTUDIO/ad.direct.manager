<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 8:50
 */

namespace app\lib\api\yandex\direct\entity;

use app\lib\api\yandex\direct\entity\campaign\DailyBudget;
use app\lib\api\yandex\direct\entity\campaign\TextCampaign;
use Faker\Provider\ar_JO\Text;
use yii\base\Object;

/**
 * Class Campaign
 * @package app\lib\api\yandex\direct\entity
 */
class Campaign extends BaseEntity
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
     * @var string
     */
    public $startDate;

    /**
     * @var string
     */
    public $clientInfo;

    /**
     * @var \app\lib\api\yandex\direct\entity\campaign\TimeTargeting
     */
    public $timeTargeting;

    /**
     * @var string
     */
    public $timeZone;

    /**
     * @var array
     */
    public $negativeKeywords = [];

    /**
     * @var array
     */
    public $blockedIps = [];

    /**
     * @var array
     */
    public $excludedSites = [];

    /**
     * @var \app\lib\api\yandex\direct\entity\campaign\DailyBudget
     */
    public $dailyBudget;

    /**
     * @var \app\lib\api\yandex\direct\entity\campaign\Notification
     */
    public $notification;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $status;

    /**
     * @var string
     */
    public $state;

    /**
     * @var string
     */
    public $statusPayment;

    /**
     * @var string
     */
    public $statusClarification;

    /**
     * @var int
     */
    public $sourceId;

    /**
     * @var \app\lib\api\yandex\direct\entity\campaign\Statistics
     */
    public $statistics;

    /**
     * @var string
     */
    public $currency;

    /**
     * @var \app\lib\api\yandex\direct\entity\campaign\FundsParam
     */
    public $funds;

    /**
     * @var \app\lib\api\yandex\direct\entity\campaign\CampaignAssistant
     */
    public $representedBy;

    /**
     * @var \app\lib\api\yandex\direct\entity\campaign\TextCampaign
     */
    public $textCampaign;

    public function __construct(array $config = [])
    {
        $this->dailyBudget = new DailyBudget();
        $this->textCampaign = new TextCampaign();
        parent::__construct($config);
    }
}
