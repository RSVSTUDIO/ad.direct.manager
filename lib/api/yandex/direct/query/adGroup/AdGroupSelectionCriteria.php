<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 27.03.16
 * Time: 21:29
 */

namespace app\lib\api\yandex\direct\query\adGroup;

use app\lib\api\yandex\direct\query\selectionCriteria\SelectionCriteria;

class AdGroupSelectionCriteria extends SelectionCriteria
{
    /**
     * @var array
     */
    public $campaignIds;

    /**
     * @var array
     */
    public $ids;

    /**
     * @var array
     */
    public $types;

    /**
     * @var array
     */
    public $statuses;

    /**
     * @var array
     */
    public $appIconStatuses;
}