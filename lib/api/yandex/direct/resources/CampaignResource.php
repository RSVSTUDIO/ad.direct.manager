<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 21.03.16
 * Time: 21:13
 */

namespace app\lib\api\yandex\direct\resources;


class CampaignResource extends AbstractResource
{
    public $resourceName = 'campaigns';

    public $queryClass = 'app\lib\api\yandex\direct\query\CampaignQuery';
}