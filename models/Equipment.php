<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

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
    public static function tableName(): string
    {
        return '{{%equipment}}';
    }

    /**
     * @return array
     */
    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => null,
                'value' => date('Y-m-d H:i:s'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['created_at'], 'safe'],
            [['client_id', 'kind', 'brand', 'sample'], 'required'],
            [['client_id'], 'integer'],
            [['description'], 'string'],
            [['kind', 'brand', 'sample', 'serial_number'], 'string', 'max' => 255],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
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
    public function getClient(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Order::class, ['equipment_id' => 'id']);
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        $kind = Kind::getByName($this->kind);
        $brand = Brand::getByName($this->brand);
        if ($kind&&$brand) {
            $this->kind = $kind->name;
            $this->brand = $brand->name;
            if (($sample = Sample::getByName($this->sample, $brand))!==null)
            {
                $this->sample = $sample->name;
                return parent::beforeSave($insert);
            }
            return false;
        }
        return false;
    }
}
