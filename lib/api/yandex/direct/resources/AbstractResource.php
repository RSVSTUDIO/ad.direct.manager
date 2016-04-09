<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 22.03.16
 * Time: 19:04
 */

namespace app\lib\api\yandex\direct\resources;

use app\lib\api\yandex\direct\Connection;
use app\lib\api\yandex\direct\entity\Campaign;
use app\lib\api\yandex\direct\query\AbstractQuery;
use app\lib\api\yandex\direct\query\ChangeResult;
use app\lib\api\yandex\direct\query\Result;
use app\lib\api\yandex\direct\system\AnnotationParser;
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
     * @throws \app\lib\api\yandex\direct\exceptions\ConnectionException
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
     * @throws \app\lib\api\yandex\direct\exceptions\ConnectionException
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
     * Обновление записи/записей
     *
     * @param $item
     * @return ChangeResult
     * @throws \app\lib\api\yandex\direct\exceptions\ConnectionException
     */
    public function update($item)
    {
        $resourceName = ucfirst($this->resourceName);

        $items = ArrayHelper::isAssociative($item) ? [$item] : $item;

        $result = $this->connection->query($this->resourceName, [$resourceName => $items], 'update');

        return new ChangeResult($result['result']['UpdateResults']);
    }

    /**
     * Архивация записи
     *
     * @param int|int[] $ids
     * @return ChangeResult
     */
    public function archive($ids)
    {
        $ids = (array)$ids;

        $result = $this->query(['SelectionCriteria' => $ids], 'archive');

        return new ChangeResult($result['result']['ArchiveResults']);
    }

    /**
     * Удаление записи/записей
     *
     * @param int|int[] $ids
     * @return ChangeResult
     * @throws \app\lib\api\yandex\direct\exceptions\ConnectionException
     */
    public function delete($ids)
    {
        $ids = (array)$ids;

        $result = $this->connection->query($this->resourceName, ['SelectionCriteria' => $ids], 'delete');

        return new ChangeResult($result['result']['DeleteResults']);
    }

    /**
     * Выполнение запроса к api
     *
     * @param array $params
     * @param string $method
     * @return mixed
     * @throws \app\lib\api\yandex\direct\exceptions\ConnectionException
     */
    protected function query(array $params = [], $method = 'get')
    {
        return $this->connection->query($this->resourceName, $params, $method);
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
