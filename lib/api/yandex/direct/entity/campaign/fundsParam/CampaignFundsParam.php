<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 17:40
 */

namespace app\lib\api\yandex\direct\entity\campaign\fundsParam;

use app\lib\api\yandex\direct\entity\BaseEntity;
use yii\base\Object;

class CampaignFundsParam extends BaseEntity
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
