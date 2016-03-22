<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 21.03.16
 * Time: 21:55
 */

namespace app\lib\yandex\direct\query;

use app\lib\yandex\direct\query\selectionCriteria\SelectionCriteriaInterface;

abstract class AbstractQuery
{
    /**
     * @var SelectionCriteriaInterface
     */
    protected $selectionCriteria;

    /**
     * Список полей, которые будут возвращены
     * @var array
     */
    protected $fieldNames;

    /**
     * Информация для пагинации
     * @var array
     */
    protected $page = [
        'limit' => null,
        'offset' => null
    ];

    /**
     * CampaignQuery constructor.
     * @param SelectionCriteriaInterface $selectionCriteria
     */
    public function __construct(SelectionCriteriaInterface $selectionCriteria = null)
    {
        $this->selectionCriteria = $selectionCriteria;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function setLimit($limit)
    {
        $this->page['limit'] = (int)$limit;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->page['limit'];
    }

    /**
     * @param int $offset
     * @return $this
     */
    public function setOffset($offset)
    {
        $this->page['offset'] = (int)$offset;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOffset()
    {
        return $this->page['offset'];
    }

    /**
     * @param array $fieldNames
     * @return $this
     */
    public function setFieldNames($fieldNames)
    {
        $this->fieldNames = (array)$fieldNames;
        return $this;
    }

    /**
     * @param SelectionCriteriaInterface $selectionCriteria
     * @return $this
     */
    public function setSelectionCriteria(SelectionCriteriaInterface $selectionCriteria)
    {
        $this->selectionCriteria = $selectionCriteria;
        return $this;
    }

    /**
     * @return SelectionCriteriaInterface
     */
    public function getSelectionCriteria()
    {
        return $this->selectionCriteria;
    }

    /**
     * @return array
     */
    public function getQuery()
    {
        $vars = array_filter(get_object_vars($this));
        $criteria = [];

        foreach ($vars as $field => $value) {
            $fieldName = ucfirst($field);
            if ($value instanceof SelectionCriteriaInterface) {
                $criteria[$fieldName] = $value->getCriteria();
            } else {
                $criteria[$fieldName] = $value;
            }
        }

        return $criteria;
    }
}
