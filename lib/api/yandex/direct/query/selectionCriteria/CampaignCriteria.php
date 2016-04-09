<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 21.03.16
 * Time: 20:56
 */

namespace app\lib\yandex\direct\query\selectionCriteria;

/**
 * Классы выборки кампаний
 * Class CampaignCriteria
 * @package app\lib\yandex\direct\query\selectionCriteria
 */
class CampaignCriteria extends SelectionCriteria
{
    const TYPE_TEXT_CAMPAIGN = 'TEXT_CAMPAIGN';
    const TYPE_MOBILE_CAMPAIGN = 'MOBILE_APP_CAMPAIGN';
    const TYPE_DYNAMIC_CAMPAIGN = 'DYNAMIC_TEXT_CAMPAIGN';

    /**
     * @var array
     */
    protected $ids;

    /**
     * @var array
     */
    protected $types = [self::TYPE_TEXT_CAMPAIGN];

    /**
     * @var array
     */
    protected $states;

    /**
     * @var array
     */
    protected $statuses;

    /**
     * @var array
     */
    protected $statusesPayment;


    public function setIds($ids)
    {
        $this->ids = (array)$ids;
        return $this;
    }

    public function getIds()
    {
        return $this->ids;
    }

    public function setTypes($types)
    {
        $this->types = (array)$types;
        return $this;
    }

    public function getTypes()
    {
        return $this->types;
    }

    /**
     * @return array
     */
    public function getStates()
    {
        return $this->states;
    }

    /**
     * @param array $states
     * @return $this
     */
    public function setStates($states)
    {
        $this->states = $states;
        return $this;
    }

    /**
     * @return array
     */
    public function getStatuses()
    {
        return $this->statuses;
    }

    /**
     * @param array $statuses
     * @return $this
     */
    public function setStatuses($statuses)
    {
        $this->statuses = $statuses;
        return $this;
    }

    /**
     * @return array
     */
    public function getStatusesPayment()
    {
        return $this->statusesPayment;
    }

    /**
     * @param array $statusesPayment
     * @return $this
     */
    public function setStatusesPayment($statusesPayment)
    {
        $this->statusesPayment = $statusesPayment;
        return $this;
    }
}
