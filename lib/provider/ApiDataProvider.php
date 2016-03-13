<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 13.03.16
 * Time: 11:38
 */

namespace app\lib\provider;

use app\components\api\shop\gateways\AbstractGateway;
use app\components\api\shop\query\BaseQuery;
use yii\base\InvalidParamException;
use yii\data\BaseDataProvider;

class ApiDataProvider extends BaseDataProvider
{
    /**
     * @var AbstractGateway
     */
    public $gateWay;

    /**
     * @var BaseQuery
     */
    public $query;

    /**
     * @var string|callable
     */
    public $key;

    /**
     * @var int
     */
    public $shopId;

    /**
     * @inheritDoc
     */
    public function init()
    {
        parent::init();
        if (!$this->gateWay) {
            throw new InvalidParamException('Gateway is required');
        }
        if (!$this->query) {
            $this->query = new BaseQuery();
        }
    }


    /**
     * @inheritDoc
     */
    protected function prepareModels()
    {
        $pagination = $this->getPagination();

        if ($pagination === false) {
            return $this->loadAdditionalInfo(
                $this->gateWay->findByQuery($this->query)
            );
        } else {
            $pagination->totalCount = $this->prepareTotalCount();
            $query = clone $this->query;
            $query
                ->limit($pagination->getLimit())
                ->setPage($pagination->getPage()+1);

            return $this->loadAdditionalInfo(
                $this->gateWay->findByQuery($query)
            );
        }
    }

    /**
     * @param array $models
     * @return mixed
     */
    protected function loadAdditionalInfo($models)
    {
        return $models;
    }

    /**
     * @inheritDoc
     */
    protected function prepareKeys($models)
    {
        if ($this->key !== null) {
            $keys = [];
            foreach ($models as $model) {
                if (is_string($this->key)) {
                    $keys[] = $model[$this->key];
                } else {
                    $keys[] = call_user_func($this->key, $model);
                }
            }

            return $keys;
        } else {
            return array_keys($models);
        }
    }

    /**
     * @inheritDoc
     */
    protected function prepareTotalCount()
    {
        $query = clone $this->query;
        return $this->gateWay->totalCount($query);
    }
}
