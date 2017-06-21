<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Record;

/**
 * RecordSearch represents the model behind the search form about `app\models\Record`.
 */
class RecordSearch extends Record
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'nr_rendor', 'pranishem'], 'integer'],
            [['qendra_id', 'emertimi', 'date_lindja'], 'safe'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Record::find();

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
            'nr_rendor' => $this->nr_rendor,
            'pranishem' => $this->pranishem,
        ]);

        $query->andFilterWhere(['like', 'qendra_id', $this->qendra_id])
            ->andFilterWhere(['like', 'emertimi', $this->emertimi])
            ->andFilterWhere(['like', 'date_lindja', $this->date_lindja]);

        return $dataProvider;
    }
}
