<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 21.03.16
 * Time: 21:13
 */

namespace app\lib\api\yandex\direct\mappers;

use app\lib\api\yandex\direct\query\CampaignQuery;

class CampaignMapper extends Mapper
{
    public $resourceName = 'campaigns';

    public $entityClass = 'app\lib\api\yandex\direct\entity\Campaign';

    public $queryClass = 'app\lib\api\yandex\direct\query\CampaignQuery';
}