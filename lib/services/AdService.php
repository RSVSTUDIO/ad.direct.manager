<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 03.04.16
 * Time: 20:27
 */

namespace app\lib\services;

use app\lib\yandex\direct\resources\AdGroupResource;
use app\lib\yandex\direct\resources\AdResource;

class AdService
{
    /**
     * @var AdGroupResource
     */
    protected $adGroupResource;

    /**
     * @var AdResource
     */
    protected $adResource;
    
    public function __construct(AdGroupResource $adGroupResource, AdResource $adResource)
    {
        $this->adGroupResource = $adGroupResource;
        $this->adResource = $adResource;
    }
}