<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 21.03.16
 * Time: 21:48
 */

namespace app\lib\api\yandex\direct\query;

use app\lib\api\yandex\direct\query\selectionCriteria\CampaignCriteria;
use app\lib\api\yandex\direct\query\selectionCriteria\Criteria;

/**
 * Класс для формирования запроса на получение кампаний
 * Class CampaignQuery
 * @package app\lib\api\yandex\direct\query
 *
 * @property CampaignCriteria $selectionCriteria
 */
class CampaignQuery extends AbstractQuery
{
    /**
     * @var array
     */
    protected $fieldNames = [
        'Id', 'Name', 'ClientInfo', 'StartDate', 'EndDate',
        'TimeTargeting', 'TimeZone', 'NegativeKeywords', 'BlockedIps',
        'ExcludedSites', 'DailyBudget', 'Notification', 'Type', 'Status',
        'State', 'StatusPayment', 'StatusClarification', 'SourceId',
        'Statistics', 'Currency', 'Funds', 'RepresentedBy',
    ];

    /**
     * @var array
     */
    protected $textCampaignFieldNames = [
        'BiddingStrategy', 'Settings', 'CounterIds',
        'RelevantKeywords'
    ];

    /**
     * @var array
     */
    protected $dynamicTextCampaignFieldNames = [
        'BiddingStrategy', 'Settings'
    ];

    /**
     * @var array
     */
    protected $mobileAppCampaignFieldNames = [
        'BiddingStrategy', 'Settings'
    ];

    /**
     * @inheritDoc
     */
    protected function createSelectionCriteria(array $params = [])
    {
        return new CampaignCriteria($params);
    }
}
