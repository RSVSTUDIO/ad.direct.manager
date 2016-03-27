<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 21.03.16
 * Time: 21:13
 */

namespace app\lib\yandex\direct\mappers;

class CampaignMapper extends Mapper
{
    public $resourceName = 'campaigns';

    public $modelClass = 'app\lib\yandex\direct\entity\Campaign';
}