<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 10:10
 */

namespace app\lib\api\yandex\direct\query;

/**
 * Результат запроса к api
 * Class Result
 * @package app\lib\api\yandex\direct\query
 */
class Result implements \ArrayAccess, \Iterator
{
    /**
     * Список записей
     * @var array
     */
    protected $items = [];

    /**
     * Доп информация о запросе
     * @var array
     */
    protected $meta = [];

    /**
     * Номер записи
     * @var int
     */
    protected $index = 0;

    /**
     * Result constructor.
     * @param array $items
     * @param array $meta
     */
    public function __construct(array $items = [], array $meta = [])
    {
        $this->items = $items;
        $this->meta = $meta;
    }

    /**
     * @inheritDoc
     */
    public function current()
    {
        return $this->items[$this->index];
    }

    /**
     * @inheritDoc
     */
    public function next()
    {
        $this->index++;
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        return isset($this->items[$this->index]);
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->index = 0;
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return isset($this->index[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->items[$this->index];
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        $this->items[$offset] = $value;
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return mixed
     */
    public function first()
    {
        return reset($this->items);
    }

    /**
     * @return mixed|null
     */
    public function lastReturnedId()
    {
        return isset($this->meta['limitedBy']) ? $this->meta['limitedBy'] : null;
    }

    /**
     * @return bool
     */
    public function isAllReceived()
    {
        return $this->lastReturnedId() === null;
    }

    /**
     * @return mixed
     */
    public function count()
    {
        return count($this->items);
    }
}
