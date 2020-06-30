<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%equipment}}".
 *
 * @property int $id
 * @property string|null $created_at
 * @property int $client_id
 * @property string|null $kind
 * @property string|null $brand
 * @property string|null $sample
 * @property string|null $serial_number
 * @property string|null $description
 *
 * @property Client $client
 * @property Order[] $orders
 */
class Equipment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%equipment}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['client_id'], 'required'],
            [['client_id'], 'integer'],
            [['description'], 'string'],
            [['kind', 'brand', 'sample', 'serial_number'], 'string', 'max' => 255],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['client_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'client_id' => 'Client ID',
            'kind' => 'Kind',
            'brand' => 'Brand',
            'sample' => 'Sample',
            'serial_number' => 'Serial Number',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['equipment_id' => 'id']);
    }
}
