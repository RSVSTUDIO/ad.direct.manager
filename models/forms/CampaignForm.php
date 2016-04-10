<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 10.04.16
 * Time: 22:07
 */

namespace app\models\forms;

use app\lib\services\YandexCampaignService;
use app\models\YandexCampaign;
use yii\helpers\ArrayHelper;

class CampaignForm extends YandexCampaign
{
    /**
     * @var string
     */
    private $keywords;

    /**
     * @var YandexCampaignService
     */
    protected $campaignService;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['keywords', 'string']
        ]);
    }

    /**
     * @param YandexCampaignService $service
     */
    public function setCampaignService(YandexCampaignService $service)
    {
        $this->campaignService = $service;
    }

    /**
     * @return string
     */
    public function getKeywords()
    {
        if (is_null($this->keywords)) {
            $keywords = ArrayHelper::getValue($this->getCampaignFromYandex(), 'NegativeKeywords.Items');
            $this->keywords = implode(', ', $keywords);
        }

        return $this->keywords;
    }

    /**
     * @param $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * @return mixed|null
     */
    protected function getCampaignFromYandex()
    {
        static $campaign;
        if (is_null($campaign)) {
            $campaign = $this->campaignService->findById($this->yandex_id);
        }

        return $campaign;
    }

    /**
     * @inheritDoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        $this->campaignService->updateNegativeKeywords($this->yandex_id, $this->keywords);
    }
}
