<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 27.03.16
 * Time: 20:27
 */

namespace app\lib\api\yandex\direct\resources;

use app\lib\api\yandex\direct\query\ChangeResult;

class AdResource extends AbstractResource
{
    public $resourceName = 'Ads';
    
    public $queryClass = 'app\lib\api\yandex\direct\query\AdQuery';

    /**
     * Остановка показа объявлений
     *
     * @param int|int[] $ids
     * @return ChangeResult
     */
    public function suspend($ids)
    {
        $ids = (array) $ids;

        $result = $this->query(['SelectionCriteria' => ['Ids' => $ids]], 'suspend');

        return new ChangeResult($result['result']['SuspendResults']);
    }

    /**
     * Отправка объявления на модерацию
     *
     * @param int $ids
     * @return ChangeResult
     */
    public function moderate($ids)
    {
        $result = $this->query(['SelectionCriteria' => ['Ids' => (array) $ids]], 'moderate');

        return new ChangeResult($result['result']['ModerateResults']);
    }

    /**
     * Убрать объвление с показа
     *
     * @param int|int[] $ids
     * @return bool
     */
    public function removeAd($ids)
    {
        $res = $this->suspend($ids);
        if (!$res->isSuccess()) {
            return false;
        }

        $res = $this->archive($ids);

        return $res->isSuccess();
    }
}
