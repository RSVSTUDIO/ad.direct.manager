<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 03.04.16
 * Time: 20:27
 */

namespace app\lib\services;

use app\lib\yandex\direct\resources\AdGroupResource;
use app\models\YandexCampaign;

class AdGroupService
{
    /**
     * @var AdGroupResource
     */
    protected $adGroupResource;
    
    public function __construct(AdGroupResource $resource)
    {
        $this->adGroupResource = $resource;
    }
    
    public function createAdGroup(array $product, YandexCampaign $campaign)
    {
        $data = [
            'Name' => $product['seo_title']
        ];
    }
}