<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 27.03.16
 * Time: 20:27
 */

namespace app\components\api\shop\query;

use app\lib\yandex\direct\query\AbstractQuery;
use app\lib\yandex\direct\query\ad\AdSelectionCriteria;

class AdQuery extends AbstractQuery
{
    public $fieldNames = [
        'Id', 'CampaignId', 'AdGroupId', 'Status',
        'StatusClarification', 'State', 'AdCategories',
        'AgeLabel', 'Type'
    ];

    public $textAdFieldNames = [
        'Title', 'Text', 'Href', 'DisplayDomain',
        'Mobile', 'VCardId', 'SitelinkSetId', 'AdImageHash',
        'VCardModeration', 'SitelinksModeration', 'AdImageModeration'
    ];

    /**
     * @inheritDoc
     */
    protected function createSelectionCriteria(array $params = [])
    {
        return new AdSelectionCriteria($params);
    }
}
