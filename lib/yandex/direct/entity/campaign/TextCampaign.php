<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 15:11
 */

namespace app\lib\yandex\direct\entity\campaign;

use app\lib\yandex\direct\entity\campaign\textCampaign\BiddingStrategy;
use yii\base\Object;

class TextCampaign extends Object
{
    /**
     * @var \app\lib\yandex\direct\entity\campaign\textCampaign\BiddingStrategy
     */
    public $biddingStrategy;

    public $settings;

    public $counterIds;

    /**
     * @var \app\lib\yandex\direct\entity\campaign\textCampaign\RelevantKeywords
     */
    public $relevantKeywords;

    /**
     * @inheritDoc
     */
    public function __construct(array $config = [])
    {
        $this->biddingStrategy = new BiddingStrategy();
        parent::__construct($config);
    }
}