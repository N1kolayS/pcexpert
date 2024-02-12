<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%service}}".
 *
 * @property int $id
 * @property int $category_id
 * @property string|null $name
 * @property string|null $duration
 * @property float|null $price
 * @property string|null $guarantee
 *
 * @property-read  CatService $category
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%service}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['category_id', 'name', 'price'], 'required'],
            [['category_id'], 'integer'],
            [['price'], 'number'],
            [['name', 'duration', 'guarantee'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatService::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория',
            'name' => 'Название',
            'duration' => 'Время работ',
            'price' => 'Цена',
            'guarantee' => 'Гарантия',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory(): \yii\db\ActiveQuery
    {
        return $this->hasOne(CatService::class, ['id' => 'category_id']);
    }

    /**
     * @return Service[]|\yii\db\ActiveRecord[]
     */
    public static function listItems(): array
    {
        return self::find()->all();
    }


}
