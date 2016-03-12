<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 12.03.16
 * Time: 12:03
 */

namespace app\components\api\shop;

class ApiResult implements \Iterator
{
    /**
     * @var array
     */
    protected $items = [];

    /**
     * @var array
     */
    protected $metadata = [];

    /**
     * @var int
     */
    protected $count = 0;

    /**
     * @var int
     */
    protected $current = 0;

    /**
     * ApiResult constructor.
     * @param array $result
     */
    public function __construct(array $result = [])
    {
        $this->items = !empty($result['items']) ? $result['items'] : [];
        $this->count = count($this->items);
        $this->setMetadata(!empty($result['metadata']) ? $result['metadata'] : []);
    }

    /**
     * Сохранение методанных запроса
     * @param array $metadata
     */
    public function setMetadata(array $metadata)
    {
        $fields = [
            'totalCount',
            'pageCount',
            'currentPage',
            'limit'
        ];
        $this->metadata = [];
        foreach ($fields as $field) {
            $this->metadata[$field] = !empty($metadata[$field]) ? $metadata[$field] : 0;
        }
    }

    /**
     * Возвращает количество элементов ответа
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Возвращает общее количество записей удовлетворяющих запросу
     * @return mixed
     */
    public function getTotalCount()
    {
        return $this->metadata['totalCount'];
    }

    /**
     * Возвращает элементы
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @inheritDoc
     */
    public function current()
    {
        return $this->items[$this->current];
    }

    /**
     * @inheritDoc
     */
    public function next()
    {
        $this->current++;
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        return $this->current;
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        return $this->current < $this->count;
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->current = 0;
    }

    /**
     * @return mixed
     */
    public function getLimit()
    {
        return $this->metadata['limit'];
    }

    /**
     * Все ли данные были переданы
     * @return bool
     */
    public function isAllDataTransferred()
    {
        return $this->getCount() < $this->getLimit();
    }
}
