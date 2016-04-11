<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 03.04.16
 * Time: 20:38
 */

namespace app\lib\api\yandex\direct\query;

use app\lib\api\yandex\direct\query\keywords\KeywordsSelectionCriteria;

class KeywordsQuery extends AbstractQuery
{
    /**
     * @var array
     */
    public $fieldNames = [
        'Id', 'AdGroupId', 'CampaignId', 'Keyword', 'Bid',
        'ContextBid', 'StrategyPriority', 'Status', 'State',
        'Productivity', 'StatisticsSearch', 'StatisticsNetwork'
    ];

    /**
     * @inheritDoc
     */
    protected function createSelectionCriteria(array $params = [])
    {
        return new KeywordsSelectionCriteria($params);
    }
}
