<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 10.04.16
 * Time: 10:10
 */

namespace app\models\forms;

use app\models\GeneratorSettings;

class GeneratorSettingsForm extends GeneratorSettings
{
    /**
     * @var array
     */
    private $brandsList;

    /**
     * @inheritDoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['brandsList', 'safe']
        ]);
    }

    /**
     * Вовзращает список брендов в виде массива
     * @return mixed
     */
    public function getBrandsList()
    {
        return explode(',', $this->brands);
    }

    /**
     * Сохраняет список брендов
     *
     * @param array $brands
     */
    public function setBrandsList($brands)
    {
        $this->brands = implode(',', (array)$brands);
    }
}
