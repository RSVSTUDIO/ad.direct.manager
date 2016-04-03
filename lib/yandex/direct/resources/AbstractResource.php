<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 22.03.16
 * Time: 19:04
 */

namespace app\lib\yandex\direct\resources;

use app\lib\yandex\direct\Connection;
use app\lib\yandex\direct\entity\Campaign;
use app\lib\yandex\direct\query\AbstractQuery;
use app\lib\yandex\direct\query\ChangeResult;
use app\lib\yandex\direct\query\Result;
use app\lib\yandex\direct\system\AnnotationParser;
use yii\helpers\ArrayHelper;

abstract class AbstractResource
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * Название ресурса получения данных
     * @var string
     */
    protected $resourceName = '';

    /**
     * @var string
     */
    protected $queryClass;

    /**
     * AbstractResource constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Поиск сущности по id
     *
     * @param mixed $id
     * @return mixed|null
     */
    public function findById($id)
    {
        $query = new $this->queryClass(['ids' => $id]);
        $result = $this->find($query);
        
        if ($result->count() > 0) {
            return $result->first();
        } else {
            return null;
        }
    }

    /**
     * Поиск
     *
     * @param AbstractQuery|array $query
     * @return Result
     * @throws \app\lib\yandex\direct\exceptions\ConnectionException
     */
    public function find($query)
    {
        if ($query instanceof AbstractQuery) {
            $query = $query->getQuery();
        }

        $result = $this->connection->query($this->resourceName, $query);

        return $this->createResult($result);
    }

    /**
     * Добавление новых ресурсов
     * @param array|array[] $params
     * @return ChangeResult
     * @throws \app\lib\yandex\direct\exceptions\ConnectionException
     */
    public function add($params)
    {
        $resourceName = ucfirst($this->resourceName);
        if (ArrayHelper::isAssociative($params)) {
            $params = [$params];
        }

        $data = [$resourceName => $params];

        $result = $this->connection->query($this->resourceName, $data, 'add');

        return new ChangeResult($result['result']['AddResults']);
    }

    /**
     * Обновление записи
     *
     * @param $params
     * @return mixed
     * @throws \app\lib\yandex\direct\exceptions\ConnectionException
     */
    public function update($params)
    {
        $resourceName = ucfirst($this->resourceName);
        $data = [$resourceName => [$params]];

        $result = $this->connection->query($this->resourceName, $data, 'update');

        return new ChangeResult($result[$resourceName]);
    }

    /**
     * Обновление нескольких записей
     *
     * @param $params
     * @return mixed
     * @throws \app\lib\yandex\direct\exceptions\ConnectionException
     */
    public function updateAll($params)
    {
        $resourceName = ucfirst($this->resourceName);
        $data = [$resourceName => $params];

        $result = $this->connection->query($this->resourceName, $data, 'update');

        return new ChangeResult($result[$resourceName]);
    }

    /**
     * @param array $result
     * @return Result|array
     */
    protected function createResult($result)
    {
        $resultField = ucfirst($this->resourceName);

        if (empty($result['result'][$resultField])) {
            return new Result();
        }

        $result = $result['result'];

        $meta = [];
        if (isset($result['LimitedBy'])) {
            $meta['limitedBy'] = $result['LimitedBy'];
        }

        return new Result($result[$resultField], $meta);
    }
}
