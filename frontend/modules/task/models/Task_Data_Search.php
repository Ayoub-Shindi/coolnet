<?php

namespace frontend\modules\task\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\task\models\Task;

/**
 * Task_Data_Search represents the model behind the search form of `frontend\modules\task\models\Task`.
 */
class Task_Data_Search extends Task
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['custom_name', 'custom_phone', 'created_at', 'task_date', 'service_type'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $query = Task::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'task_date' => $this->task_date,
        ]);

        $query->andFilterWhere(['like', 'custom_name', $this->custom_name])
            ->andFilterWhere(['like', 'custom_phone', $this->custom_phone])
            ->andFilterWhere(['like', 'service_type', $this->service_type]);

        return $dataProvider;
    }
}
