<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 27.03.16
 * Time: 20:28
 */

namespace app\lib\api\yandex\direct\query\ad;

use app\lib\api\yandex\direct\query\selectionCriteria\SelectionCriteria;

class AdSelectionCriteria extends SelectionCriteria
{
    /**
     * @var array
     */
    public $ids;

    /**
     * @var array
     */
    public $states;

    /**
     * @var array
     */
    public $statuses;

    /**
     * @var array
     */
    public $campaignIds;

    /**
     * @var array
     */
    public $adGroupIds;

    /**
     * @var array
     */
    public $types;

    /**
     * @var string
     */
    public $mobile;

    /**
     * @var array
     */
    public $vCardIds;
}