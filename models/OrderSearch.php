<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Order;

/**
 * OrderSearch represents the model behind the search form of `app\models\Order`.
 */
class OrderSearch extends Order
{
    public $client_fio;
    public $date_from;
    public $date_to;
    public $date_range;
    public $clientFio;
    public $clientPhone;
    public $equipmentKind;
    public $equipmentBrand;
    public $equipmentSample;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'equipment_id', 'client_id', 'manager_id', 'master_id', 'status', 'placement'], 'integer'],
            [['created_at', 'hired_at', 'closed_at', 'problems', 'kit', 'comment'], 'safe'],
            [['prepayment', 'cost'], 'number'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
            [['date_range', 'clientFio', 'clientPhone', 'equipmentKind', 'equipmentBrand', 'equipmentSample'], 'string']
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
        $query = Order::find();

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
            'hired_at' => $this->hired_at,
            'closed_at' => $this->closed_at,
            'equipment_id' => $this->equipment_id,
            'client_id' => $this->client_id,
            'manager_id' => $this->manager_id,
            'master_id' => $this->master_id,
            'status' => $this->status,
            'placement' => $this->placement,
            'prepayment' => $this->prepayment,
            'cost' => $this->cost,
        ]);

        $query->andFilterWhere(['like', 'problems', $this->problems])
            ->andFilterWhere(['like', 'kit', $this->kit])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['>=', 'created_at', $this->date_from])
            ->andFilterWhere(['<=', 'created_at', $this->date_to ]);

        return $dataProvider;
    }
}
