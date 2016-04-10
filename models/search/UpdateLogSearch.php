<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 10.04.16
 * Time: 15:41
 */

namespace app\models\search;

use app\models\YandexUpdateLog;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UpdateLogSearch extends YandexUpdateLog
{
    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [
            [['entity_type', 'entity_id', 'operation', 'status', 'created_at'], 'safe']
        ];
    }

    /**
     * @inheritDoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params = [])
    {
        $query = YandexUpdateLog::find();

        $query->joinWith(['product', 'campaign']);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        
        $this->load($params);

        $query->andWhere(['task_id' => $this->task_id]);
        
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'entity_id' => $this->entity_id,
            'created_at' => $this->created_at
        ]);

        $query->andFilterWhere(['LIKE', 'entity_type', $this->entity_type]);
        $query->andFilterWhere(['LIKE', 'operation', $this->operation]);
        $query->andFilterWhere(['LIKE', 'status', $this->status]);
        
        return $dataProvider;
    }
}