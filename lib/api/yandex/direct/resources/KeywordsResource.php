<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 27.03.16
 * Time: 22:41
 */

namespace app\lib\api\yandex\direct\resources;

class KeywordsResource extends AbstractResource
{
    protected $resourceName = 'Keywords';
    
    protected $queryClass = 'app\lib\api\yandex\direct\query\KeywordsQuery';
}