<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 15:09
 */

namespace app\lib\api\yandex\direct\entity\campaign;

use app\lib\api\yandex\direct\entity\BaseEntity;
use yii\base\Object;

class FundsParam extends BaseEntity
{
    /**
     * @var string
     */
    public $mode;

    /**
     * @var \app\lib\api\yandex\direct\entity\campaign\fundsParam\CampaignFundsParam
     */
    public $campaignFunds;

    /**
     * @var \app\lib\api\yandex\direct\entity\campaign\fundsParam\SharedAccountFundsParam
     */
    public $sharedAccountFunds;
}
