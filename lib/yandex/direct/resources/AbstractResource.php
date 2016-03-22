<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 22.03.16
 * Time: 19:04
 */

namespace app\lib\yandex\direct\resources;

use app\lib\yandex\direct\Connection;

abstract class AbstractResource
{
    /**
     * @var Connection
     */
    protected $connection;
    
    protected $resourceName = '';
    
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }
    
    public function query(array $params)
    {
        $this->connection->query($this->resourceName, $params);
    }
}