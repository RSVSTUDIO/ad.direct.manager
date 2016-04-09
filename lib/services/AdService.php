<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 03.04.16
 * Time: 20:27
 */

namespace app\lib\services;

use app\lib\api\shop\models\ApiProduct;
use app\lib\api\yandex\direct\exceptions\YandexException;
use app\lib\api\yandex\direct\resources\AdResource;
use app\models\Product;
use app\models\Template;

class AdService extends YandexService
{
    const MAX_TITLE_LENGTH = 33;

    const MAX_MESSAGE_LENGTH = 75;

    /**
     * @var AdResource
     */
    protected $adResource;
    
    public function __construct(AdResource $adResource)
    {
        $this->adResource = $adResource;
    }

    /**
     * @param Product $product
     * @param ApiProduct $apiProduct
     * @return int
     * @throws YandexException
     */
    public function createAd(Product $product, ApiProduct $apiProduct)
    {
        $textAdData = $this->getAdTemplate($product, $apiProduct);

        if (!$textAdData) {
            throw new YandexException('Template for product not found');
        }

        $data = [
            'TextAd' => [
                'Href' => $apiProduct->href,
               // 'AdImageHash' => $apiProduct->image,
                'Mobile' => 'NO'
            ],
            'AdGroupId' => $product->yandex_adgroup_id
        ];

        $data['TextAd'] = array_merge($data['TextAd'], $textAdData);

        $result = $this->adResource->add($data);

        if (!$result->isSuccess()) {
            $this->throwExceptionFromResult($result);
        }

        return $result->getIds()[0];
    }

    /**
     * Обновление объявления
     *
     * @param Product $product
     * @param ApiProduct $apiProduct
     * @return bool
     * @throws YandexException
     */
    public function update(Product $product, ApiProduct $apiProduct)
    {
        $textAdData = $this->getAdTemplate($product, $apiProduct);
        if (!$textAdData) {
            throw new YandexException('Template for product not found');
        }

        $data = [
            'Id' => $product->yandex_ad_id,
            'TextAd' => [
                'AdImageHash' => $apiProduct->image,
            ]
        ];

        $data['TextAd'] = array_merge($data['TextAd'], $textAdData);

        $result = $this->adResource->update($data);

        return $result->isSuccess();
    }

    /**
     * @param Product $product
     * @param ApiProduct $apiProduct
     * @return array|null
     */
    protected function getAdTemplate(Product $product, ApiProduct $apiProduct)
    {
        $placeholders = [
            '[brand]' => $apiProduct->getBrandTitle(),
            '[category]' => $apiProduct->getCategory(),
            '[price]' => $product->price,
            '[title]' => $product->seo_title ?: substr($product->title, 0, 33)
        ];

        /** @var Template[] $templates */
        $templates = Template::find()->orderBy('id')->all();

        foreach ($templates as $template) {
            $title = strtr($template->title, $placeholders);
            $message = strtr($template->message, $placeholders);

            if (strlen($title) <= self::MAX_TITLE_LENGTH
                && strlen($message) <= self::MAX_MESSAGE_LENGTH
            ) {
                return [
                    'Title' => $title,
                    'Text' => $message
                ];
            }
        }

        return null;
    }

    /**
     * Снятие объявления с показа
     *
     * @param Product $product
     * @return bool
     */
    public function removeAd(Product $product)
    {
        return $this->adResource->removeAd($product->yandex_ad_id);
    }
}
