<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 27.03.16
 * Time: 21:28
 */

namespace app\lib\api\yandex\direct\query;

use app\lib\api\yandex\direct\query\adGroup\AdGroupSelectionCriteria;

/**
 * Class AdGroupQuery
 * @package app\lib\api\yandex\direct\query
 *
 * @property AdGroupSelectionCriteria $selectionCriteria
 */
class AdGroupQuery extends AbstractQuery
{
    public $fieldNames = [
        'Id', 'Name', 'CampaignId', 'RegionIds', 'NegativeKeywords',
        'TrackingParams', 'Status', 'Type'
    ];
    
    public $dynamicTextAdGroupFieldNames = [
        'DomainUrl', 'DomainUrlProcessingStatus'
    ];

    /**
     * @inheritDoc
     */
    protected function createSelectionCriteria(array $params = [])
    {
        return new AdGroupSelectionCriteria($params);
    }

}