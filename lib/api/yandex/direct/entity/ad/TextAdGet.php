<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 27.03.16
 * Time: 15:50
 */

namespace app\lib\api\yandex\direct\entity\ad;

use app\lib\api\yandex\direct\entity\BaseEntity;

class TextAdGet extends BaseEntity
{
    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $text;

    /**
     * @var string
     */
    public $href;

    /**
     * @var string
     */
    public $displayDomain;

    /**
     * @var string
     */
    public $mobile;

    /**
     * @var string
     */
    public $vCardId;

    /**
     * @var int
     */
    public $siteLinkSetId;

    /**
     * @var string
     */
    public $adImageHash;
}