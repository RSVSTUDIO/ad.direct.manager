<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 21.03.16
 * Time: 21:13
 */

namespace app\lib\yandex\direct\resources;


class CampaignResource extends AbstractResource
{
    public $resourceName = 'campaigns';

    public $queryClass = 'app\lib\yandex\direct\query\CampaignQuery';
}