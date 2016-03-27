<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 22.03.16
 * Time: 19:04
 */

namespace app\lib\yandex\direct\mappers;

use app\lib\yandex\direct\Connection;
use app\lib\yandex\direct\entity\Campaign;
use app\lib\yandex\direct\query\AbstractQuery;
use app\lib\yandex\direct\query\Result;
use app\lib\yandex\direct\system\AnnotationParser;

abstract class Mapper
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
    protected $entityClass;

    /**
     * @var string
     */
    protected $queryClass;

    /**
     * @var AnnotationParser
     */
    protected $annotationParser;

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

    public function add($params)
    {
        return $this->connection->query($this->resourceName, $params, 'update');
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
        $data = [ucfirst($this->resourceName) => [$params]];

        $result = $this->connection->query($this->resourceName, $data, 'update');
        if (!empty($result['result']['UpdateResults'])) {
            return true;
        } else {
            return false;
        }
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
        $data = [ucfirst($this->resourceName) => $params];

        return $this->connection->query($this->resourceName, $data, 'update');
    }

    /**
     * @param array $result
     * @return Result|array
     */
    protected function createResult($result)
    {
        $items = [];
        $resultField = ucfirst($this->resourceName);

        if (empty($result['result'][$resultField])) {
            return new Result();
        }

        $result = $result['result'];

        foreach ($result[$resultField] as $item) {
            $items[] = $this->populateModel($item, $this->entityClass);
        }

        $meta = [];
        if (isset($result['LimitedBy'])) {
            $meta['limitedBy'] = $result['LimitedBy'];
        }

        return new Result($items, $meta);
    }

    /**
     * @param array $item
     * @param string $modelClass
     * @return Object
     */
    protected function populateModel($item, $modelClass)
    {
        $classAttributes = $this->getAnnotationParser()
            ->parseAttributes($modelClass);

        $data = [];
        foreach ($classAttributes as $field => $fieldInfo) {
            $type = $fieldInfo['type'];
            $apiFieldName = $fieldInfo['apiName'];
            $modelFieldName = $fieldInfo['modelName'];
            
            if (!isset($item[$apiFieldName])) {
                $data[$modelFieldName] = null;
                continue;
            }

            if (strpos($type, '\\') !== false) {
                $data[$modelFieldName] = $this->populateModel($item[$apiFieldName], $type);
            } else {
                $data[$modelFieldName] = $item[$apiFieldName];
            }
        }

        return new $modelClass($data);
    }

    /**
     * @return AnnotationParser
     */
    protected function getAnnotationParser()
    {
        if (is_null($this->annotationParser)) {
            $this->annotationParser = new AnnotationParser();
        }

        return $this->annotationParser;
    }
}
