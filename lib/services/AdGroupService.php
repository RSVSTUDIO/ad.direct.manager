<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 03.04.16
 * Time: 20:27
 */

namespace app\lib\services;

use app\lib\api\yandex\direct\exceptions\YandexException;
use app\lib\api\yandex\direct\resources\AdGroupResource;
use app\models\Product;
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

    /**
     * @param Product $product
     * @return mixed
     * @throws YandexException
     */
    public function createAdGroup(Product $product)
    {
        $data = [
            'Name' => $product->seo_title ?: substr($product->title, 0, 33),
            'CampaignId' => $product->yandexCampaign->yandex_id,
            'RegionIds' => [1, -219]
        ];
        
        $result = $this->adGroupResource->add($data);
        
        if (!$result->isSuccess()) {
            $errorInfo = $result->firstError();
            $errorMsg = $errorInfo['Message'];
            if (!empty($errorInfo['Details'])) {
                $errorMsg .= ': ' . $errorInfo['Details'];
            }

            throw new YandexException($errorMsg, $errorInfo['Code']);
        }
        
        $product->yandex_adgroup_id = $result->getIds()[0]; 
        
        return $result->getIds()[0];
    }
}
