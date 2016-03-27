<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 21.03.16
 * Time: 21:55
 */

namespace app\lib\yandex\direct\query;

use app\lib\yandex\direct\query\selectionCriteria\LimitOffset;
use app\lib\yandex\direct\query\selectionCriteria\Criteria;
use app\lib\yandex\direct\query\selectionCriteria\CriteriaInterface;
use yii\base\Object;
use yii\gii\generators\extension\CriteriaException;

abstract class AbstractQuery extends Object
{
    /**
     * @var CriteriaInterface
     */
    protected $selectionCriteria;

    /**
     * Список полей, которые будут возвращены
     * @var array
     */
    protected $fieldNames = [];

    /**
     * Информация для пагинации
     * @var LimitOffset
     */
    protected $page;

    /**
     * AbstractQuery constructor.
     * @param null|array|CriteriaInterface $criteria
     * @param array $page
     * @param array $config
     */
    public function __construct($criteria = [], $page = [], $config = [])
    {
        $this->setSelectionCriteria($criteria);
        $this->setPage($page);
        parent::__construct($config);
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function setLimit($limit)
    {
        $this->page->setLimit($limit);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->page->getLimit();
    }

    /**
     * @param int $offset
     * @return $this
     */
    public function setOffset($offset)
    {
        $this->page->setOffset($offset);
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOffset()
    {
        return $this->page->getOffset();
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
     * @param string|array $fieldName
     * @return $this
     */
    public function addFieldName($fieldName)
    {
        $this->fieldNames = array_merge($this->fieldNames, (array)$fieldName);
        return $this;
    }

    /**
     * @param array|CriteriaInterface $selectionCriteria
     * @return $this
     * @throws CriteriaException
     */
    public function setSelectionCriteria($selectionCriteria)
    {
        if ($selectionCriteria instanceof CriteriaInterface) {
            $this->selectionCriteria = $selectionCriteria;
        } elseif (is_array($selectionCriteria)) {
            $this->selectionCriteria = $this->createSelectionCriteria($selectionCriteria);
        } else {
            throw new CriteriaException('Wrong selection criteria');
        }
        return $this;
    }

    /**
     * @return CriteriaInterface
     */
    public function getSelectionCriteria()
    {
        return $this->selectionCriteria;
    }

    /**
     * @return LimitOffset
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param array|LimitOffset $page
     * @return $this
     */
    public function setPage($page)
    {
        if ($page instanceof LimitOffset) {
            $this->page = $page;
        } elseif (is_array($page)) {
            $this->page = new LimitOffset($page);
        }

        return $this;
    }

    /**
     * Фабричный метод создания критерии для конкретного запроса
     * @param array $params
     * @return mixed
     */
    abstract protected function createSelectionCriteria(array $params = []);

    /**
     * @return array
     */
    public function getQuery()
    {
        $vars = array_filter(get_object_vars($this));
        $criteria = [];

        foreach ($vars as $field => $value) {
            $fieldName = ucfirst($field);
            if ($value instanceof CriteriaInterface) {
                $criteria[$fieldName] = $value->getCriteria();
            } else {
                $criteria[$fieldName] = $value;
            }
        }

        return $criteria;
    }
}
