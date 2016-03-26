<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 17:40
 */

namespace app\lib\yandex\direct\entity\campaign\fundsParam;

use yii\base\Object;

class CampaignFundsParam extends Object
{
    /**
     * @var int
     */
    public $sum;

    /**
     * @var int
     */
    public $balance;

    /**
     * @var int
     */
    public $balanceBonus;

    /**
     * @var int
     */
    public $sumAvailableForTransfer;
}
