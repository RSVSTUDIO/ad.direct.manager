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

class KeywordsService
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

    public function createKeywordsFor(Product $product)
    {
        $data = [
            'Keyword'
        ];
    }
}
