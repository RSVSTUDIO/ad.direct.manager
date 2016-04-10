<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 03.04.16
 * Time: 15:06
 */

namespace app\lib\services;

use app\lib\api\yandex\direct\exceptions\YandexException;
use app\lib\api\yandex\direct\resources\CampaignResource;
use app\models\Settings;
use app\models\YandexCampaign;

class YandexCampaignService extends YandexService
{
    const MIN_DAILY_BUDGET = 301;

    /**
     * @var CampaignResource
     */
    protected $campaignResource;

    /**
     * YandexCampaignService constructor.
     * @param CampaignResource $resource
     */
    public function __construct(CampaignResource $resource)
    {
        $this->campaignResource = $resource;
    }

    /**
     * @param int $shopId
     * @param int $brandId
     * @return YandexCampaign
     */
    public function getCampaign($shopId, $brandId)
    {
        return YandexCampaign::getCampaign($shopId, $brandId);
    }

    /**
     * Создает новую кампанию
     *
     * @param string $name название кампании
     * @return YandexCampaign
     * @throws YandexException
     */
    public function createCampaign($name, $shopId, $brandId)
    {
        $name = $this->generateCampaignName($name, $shopId, $brandId);
        $result = $this->campaignResource->add($this->getCampaignData($name));

        if (!$result->isSuccess()) {
            $this->throwExceptionFromResult($result);
        }

        $campaignId = $result->getIds()[0];

        $campaign = new YandexCampaign([
            'shop_id' => $shopId,
            'brand_id' => $brandId,
            'yandex_id' => $campaignId,
            'negative_keywords' => Settings::getValue('negativeKeywords'),
            'title' => $name,
            'products_count' => 0
        ]);

        $campaign->save();

        return $campaign;
    }

    /**
     * @param $name
     * @param $shopId
     * @param $brandId
     * @return string
     */
    protected function generateCampaignName($name, $shopId, $brandId)
    {
        $brandCampaignCount = YandexCampaign::find()
            ->andWhere([
                'shop_id' => $shopId,
                'brand_id' => $brandId
            ])->count();
        
        if ($brandCampaignCount == 0) {
            return $name;
        } else {
            return $name . ' (' . ($brandCampaignCount + 1) . ')';
        }
    }

    /**
     * @param $name
     * @return array
     */
    protected function getCampaignData($name)
    {
        $campaignData = [
            'Name' => $name,
            'StartDate' => date('Y-m-d'),
            'DailyBudget' => [
                'Amount' => self::MIN_DAILY_BUDGET * 1000000,
                'Mode' => 'STANDARD'
            ],
            'TextCampaign' => [
                'BiddingStrategy' => [
                    'Search' => [
                        'BiddingStrategyType' => 'LOWEST_COST'
                    ],
                    'Network' => [
                        'BiddingStrategyType' => 'SERVING_OFF'
                    ]
                ],
                'Settings' => [
                    [
                        'Option' => 'ENABLE_AREA_OF_INTEREST_TARGETING',
                        'Value' => 'NO'
                    ]
                ]
            ],
        ];

        $negativeKeywords = $this->parseKeywords(Settings::getValue('negativeKeywords'));

        if (!empty($negativeKeywords)) {
            $campaignData['NegativeKeywords'] = [
                'Items' => $negativeKeywords
            ];
        }

        return $campaignData;
    }

    /**
     * Возвращает ключевые слова в виде массива из строки
     *
     * @param string $keywords
     * @return mixed
     */
    protected function parseKeywords($keywords)
    {
        $keywords = preg_split('#(\s+|,)#', $keywords, -1, PREG_SPLIT_NO_EMPTY);

        return array_unique(array_map('trim', $keywords));
    }

    /**
     * Обновление минус слов кампании
     *
     * @param int $id
     * @param string $keywords
     * @return bool
     */
    public function updateNegativeKeywords($id, $keywords)
    {
        $updateData = [
            'Id' => $id,
            'NegativeKeywords' => [
                'Items' => $this->parseKeywords($keywords)
            ]
        ];

        $result = $this->campaignResource->update($updateData);

        if (!$result->isSuccess()) {
            $this->throwExceptionFromResult($result);
        }

        return $result->isSuccess();
    }
}
