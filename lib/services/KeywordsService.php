<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 09.04.16
 * Time: 11:02
 */

namespace app\lib\services;

use app\lib\api\yandex\direct\query\KeywordsQuery;
use app\lib\api\yandex\direct\resources\KeywordsResource;
use app\models\Product;
use yii\helpers\ArrayHelper;

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

    /**
     * Обновление ключевых слов
     *
     * @param Product $product
     * @return bool
     * @throws \app\lib\api\yandex\direct\exceptions\YandexException
     */
    public function updateKeywords(Product $product)
    {
        $items = $this->resource->find(
            new KeywordsQuery(['adGroupIds' => [$product->yandex_adgroup_id]]),
            ['id', 'adGroupId', 'keyword']
        );

        $keywords = array_map('trim', explode(',', $product->keywords));

        $deleteIds = [];
        $existsKeywords = [];
        foreach ($items as $item) {
            if (!in_array($item['Keyword'], $keywords)) {
                $deleteIds[] = $item['Id'];
            } else {
                $existsKeywords[] = $item['Keyword'];
            }
        }

        $result = $this->resource->delete($deleteIds);
        if (!$result->isSuccess()) {
            $this->throwExceptionFromResult($result);
        }

        //ключевые слова для добавления
        $newKeywords = array_diff($keywords, $existsKeywords);

        if (empty($newKeywords)) {
            return true;
        }

        $newKeywordsItems = [];

        foreach ($newKeywords as $keyword) {
            $newKeywordsItems[] = [
                'Keyword' => $keyword,
                'AdGroupId' => $product->yandex_adgroup_id
            ];
        }

        $result = $this->resource->add($newKeywordsItems);

        if (!$result->isSuccess()) {
            $this->throwExceptionFromResult($result);
        }

        return true;
    }
}
