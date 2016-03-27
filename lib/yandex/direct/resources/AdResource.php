<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 27.03.16
 * Time: 20:27
 */

namespace app\lib\yandex\direct\resources;

class AdResource extends AbstractResource
{
    public $resourceName = 'Ads';
    
    public $queryClass = 'app\lib\yandex\direct\query\AdQuery';
}