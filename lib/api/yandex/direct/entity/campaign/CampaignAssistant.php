<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 15:10
 */

namespace app\lib\api\yandex\direct\entity\campaign;

use app\lib\api\yandex\direct\entity\BaseEntity;
use yii\base\Object;

class CampaignAssistant extends BaseEntity
{
    /**
     * @var string
     */
    public $manager;

    /**
     * @var string
     */
    public $agency;
}