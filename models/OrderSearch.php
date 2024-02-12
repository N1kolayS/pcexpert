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

    public ?string $date_from = null;
    public ?string $date_to = null;
    public ?string $date_range = null;
    public ?string $client_fio = null;
    public ?string $client_phone = null;
    public ?string $equipment_kind = null;
    public ?string $equipment_brand = null;
    public ?string $equipment_sample = null;
    public ?string $equipment_serial_number = null;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'equipment_id', 'client_id', 'manager_id', 'master_id', 'status', 'placement'], 'integer'],
            [['created_at', 'hired_at', 'closed_at', 'problems', 'kit', 'comment'], 'safe'],
            [['prepayment', 'cost'], 'number'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
            [['date_range', 'client_fio', 'client_phone', 'equipment_kind', 'equipment_brand', 'equipment_sample', 'equipment_serial_number'], 'string'],
            [[ 'equipment_kind', 'equipment_brand', 'equipment_sample'], 'trim']
        ];
    }



    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
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
    public function search(array $params): ActiveDataProvider
    {
        $query = Order::find();
        $query->andWhere(['<', Order::tableName().'.status', Order::STATUS_CLOSE_PASSED]);
        $query->joinWith(['equipment', 'client']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);

        $dataProvider->sort->attributes['equipment_kind'] = [
            'asc' => [Equipment::tableName().'.kind' => SORT_ASC],
            'desc' => [Equipment::tableName().'.kind' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['equipment_brand'] = [
            'asc' => [Equipment::tableName().'.brand' => SORT_ASC],
            'desc' => [Equipment::tableName().'.brand' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['equipment_serial_number'] = [
            'asc' => [Equipment::tableName().'.serial_number' => SORT_ASC],
            'desc' => [Equipment::tableName().'.serial_number' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['equipment_sample'] = [
            'asc' => [Equipment::tableName().'.sample' => SORT_ASC],
            'desc' => [Equipment::tableName().'.sample' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['client_fio'] = [
            'asc' => [Client::tableName().'.fio' => SORT_ASC],
            'desc' => [Client::tableName().'.fio' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['client_phone'] = [
            'asc' => [Client::tableName().'.phone' => SORT_ASC],
            'desc' => [Client::tableName().'.phone' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            self::tableName().'.id' => $this->id,
            'hired_at' => $this->hired_at,
            'closed_at' => $this->closed_at,
            'equipment_id' => $this->equipment_id,
            'client_id' => $this->client_id,
            Equipment::tableName().'.kind' => $this->equipment_kind,
            Equipment::tableName().'.brand' => $this->equipment_brand,
            Equipment::tableName().'.sample' => $this->equipment_sample,
            Equipment::tableName().'.serial_number' => $this->equipment_serial_number,
            'placement' => $this->placement,
            'prepayment' => $this->prepayment,
            'cost' => $this->cost,
        ]);

        $query->andFilterWhere(['like', 'problems', $this->problems])
            ->andFilterWhere(['like', 'kit', $this->kit])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', Client::tableName().'.fio', $this->client_fio])
            ->andFilterWhere(['like', Client::tableName().'.phone', $this->client_phone])
            ->andFilterWhere(['>=', Order::tableName().'.created_at', $this->date_from])
            ->andFilterWhere(['<=', Order::tableName().'.created_at', $this->date_to ]);

        return $dataProvider;
    }


    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function searchArchive($params): ActiveDataProvider
    {
        $query = Order::find();
        $query->andWhere(['>=', Order::tableName().'.status', Order::STATUS_CLOSE_PASSED]);
        $query->joinWith(['equipment', 'client']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);

        $dataProvider->sort->attributes['equipment_kind'] = [
            'asc' => [Equipment::tableName().'.kind' => SORT_ASC],
            'desc' => [Equipment::tableName().'.kind' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['equipment_brand'] = [
            'asc' => [Equipment::tableName().'.brand' => SORT_ASC],
            'desc' => [Equipment::tableName().'.brand' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['equipment_sample'] = [
            'asc' => [Equipment::tableName().'.sample' => SORT_ASC],
            'desc' => [Equipment::tableName().'.sample' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['equipment_serial_number'] = [
            'asc' => [Equipment::tableName().'.serial_number' => SORT_ASC],
            'desc' => [Equipment::tableName().'.serial_number' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['client_fio'] = [
            'asc' => [Client::tableName().'.fio' => SORT_ASC],
            'desc' => [Client::tableName().'.fio' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['client_phone'] = [
            'asc' => [Client::tableName().'.phone' => SORT_ASC],
            'desc' => [Client::tableName().'.phone' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            self::tableName().'.id' => $this->id,
            'hired_at' => $this->hired_at,
            'closed_at' => $this->closed_at,
            'equipment_id' => $this->equipment_id,
            'client_id' => $this->client_id,
            Equipment::tableName().'.kind' => $this->equipment_kind,
            Equipment::tableName().'.brand' => $this->equipment_brand,
            Equipment::tableName().'.sample' => $this->equipment_sample,
            Equipment::tableName().'.serial_number' => $this->equipment_serial_number,
            'placement' => $this->placement,
            'prepayment' => $this->prepayment,
            'cost' => $this->cost,
        ]);

        $query->andFilterWhere(['like', 'problems', $this->problems])
            ->andFilterWhere(['like', 'kit', $this->kit])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', Client::tableName().'.fio', $this->client_fio])
            ->andFilterWhere(['like', Client::tableName().'.phone', $this->client_phone])
            ->andFilterWhere(['>=', Order::tableName().'.created_at', $this->date_from])
            ->andFilterWhere(['<=', Order::tableName().'.created_at', $this->date_to ]);

        return $dataProvider;
    }
}
