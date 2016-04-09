<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 08.03.16
 * Time: 22:23
 */

namespace app\lib\api\shop\query;

use yii\base\Object;
use yii\helpers\Inflector;

class BaseQuery extends Object implements QueryInterface
{
    /**
     * @var int
     */
    protected $limit;

    /**
     * @var int
     */
    protected $offset;

    /**
     * @var
     */
    protected $page;

    /**
     * @param int $limit
     * @return $this
     */
    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @param int $offset
     * @return $this
     */
    public function offset($offset)
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * @param int $page
     * @return $this
     */
    public function setPage($page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @inheritdoc
     */
    public function getQuery()
    {
        $vars = array_filter(
            get_object_vars($this),
            function ($value) {
                return !is_null($value);
            }
        );
        $result = [];
        foreach ($vars as $key => $value) {
            $result[Inflector::underscore($key)] = is_array($value) ? implode(',', $value) : $value;
        }

        return $result;
    }
}
