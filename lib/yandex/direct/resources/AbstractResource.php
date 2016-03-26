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
use app\lib\yandex\direct\helpers\YandexHelper;
use app\lib\yandex\direct\query\AbstractQuery;
use app\lib\yandex\direct\query\Result;
use app\lib\yandex\direct\system\AnnotationParser;
use yii\base\Object;

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
    protected $modelClass = 'app\lib\yandex\direct\models\BaseModel';

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

    public function add($models)
    {
        
    }

    public function update()
    {
        
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
            $items[] = $this->populateModel($item, $this->modelClass);
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
        $item = YandexHelper::convertFieldNames($item);

        $classAttributes = $this->getAnnotationParser()
            ->parseAttributes($modelClass);

        $data = [];
        foreach ($classAttributes as $field => $type) {
            if (!isset($item[$field])) {
                $data[$field] = null;
                continue;
            }

            if (strpos($type, '\\') !== false) {
                $data[$field] = $this->populateModel($item[$field], $type);
            } else {
                $data[$field] = $item[$field];
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
