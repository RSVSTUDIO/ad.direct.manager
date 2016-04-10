<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TaskQueue;
use yii\db\ActiveQuery;

/**
 * TaskQueueSearch represents the model behind the search form about `app\models\TaskQueue`.
 */
class TaskQueueSearch extends TaskQueue
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'shop_id'], 'integer'],
            [['created_at', 'started_at', 'status', 'operation', 'completed_at', 'context', 'error', 'shop.name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * @inheritDoc
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), ['shop.name']);
    }


    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TaskQueue::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $query->joinWith(['shop' => function (ActiveQuery $query) {
            return $query->from(['shop' => 'shops']);
        }]);

        $dataProvider->sort->attributes['shop.name'] = [
            'asc' => ['shop.name' => SORT_ASC],
            'desc' => ['shop.name' => SORT_DESC]
        ];

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'task_queue.id' => $this->id,
            'shop_id' => $this->shop_id,
            'created_at' => $this->created_at,
            'started_at' => $this->started_at,
            'completed_at' => $this->completed_at,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'operation', $this->operation])
            ->andFilterWhere(['like', 'context', $this->context])
            ->andFilterWhere(['like', 'error', $this->error])
            ->andFilterWhere(['like', 'shop.name', $this->getAttribute('shop.name')]);

        return $dataProvider;
    }
}
