<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 03.04.16
 * Time: 20:39
 */

namespace app\lib\api\yandex\direct\query\keywords;

use app\lib\api\yandex\direct\query\selectionCriteria\SelectionCriteria;

class KeywordsSelectionCriteria extends SelectionCriteria
{
    /**
     * @var array
     */
    public $ids;

    /**
     * @var array
     */
    public $adGroupIds;

    /**
     * @var array
     */
    public $campaignIds;

    /**
     * @var array
     */
    public $states;

    /**
     * @var array
     */
    public $statuses;
}
