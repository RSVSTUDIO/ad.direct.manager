<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 27.03.16
 * Time: 22:41
 */

namespace app\lib\yandex\direct\resources;

class AdGroupResource extends AbstractResource
{
    protected $resourceName = 'AdGroups';
    
    protected $queryClass = 'app\lib\yandex\direct\query\AdGroupQuery';
}