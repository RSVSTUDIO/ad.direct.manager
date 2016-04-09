<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 09.04.16
 * Time: 11:02
 */

namespace app\lib\services;

use app\lib\api\yandex\direct\resources\KeywordsResource;
use app\models\Product;

class KeywordsService extends YandexService
{
    /**
     * @var KeywordsResource
     */
    protected $resource;

    /**
     * KeywordsService constructor.
     * @param KeywordsResource $resource
     */
    public function __construct(KeywordsResource $resource)
    {
        $this->resource = $resource;
    }

    /**
     * @param Product $product
     * @return null
     */
    public function createKeywordsFor(Product $product)
    {
        if (!$product->keywords) {
            return null;
        }

        $keywords = array_map('trim', explode(',', $product->keywords));

        foreach ($keywords as $keyword) {
            $data = [
                'Keyword' => $keyword,
                'AdGroupId' => $product->yandex_adgroup_id
            ];
            $this->resource->add($data);
        }
    }
}
