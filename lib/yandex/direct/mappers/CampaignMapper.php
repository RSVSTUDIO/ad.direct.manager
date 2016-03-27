<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 21.03.16
 * Time: 21:13
 */

namespace app\lib\yandex\direct\mappers;

use app\lib\yandex\direct\query\CampaignQuery;

class CampaignMapper extends Mapper
{
    public $resourceName = 'campaigns';

    public $entityClass = 'app\lib\yandex\direct\entity\Campaign';

    public $queryClass = 'app\lib\yandex\direct\query\CampaignQuery';
}