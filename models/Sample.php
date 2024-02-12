<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%sample}}".
 *
 * @property int $id
 * @property int $brand_id
 * @property string|null $name
 *
 * @property Brand $brand
 */
class Sample extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%sample}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['brand_id', 'name'], 'required'],
            [['brand_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brand::class, 'targetAttribute' => ['brand_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'brand_id' => 'Производитель',
            'name' => 'Название',
        ];
    }

    /**
     * Gets query for [[Brand]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBrand(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Brand::className(), ['id' => 'brand_id']);
    }

    /**
     * @param string $name
     * @param Brand $brand
     * @return Sample
     */
    public static function getByName(string $name, Brand $brand): Sample
    {
        $model = self::findOne(['name' => $name]);
        if (!$model)
        {
            $model = new Sample();
            $model->brand_id = $brand->id;
            $model->name = $name;
            $model->save();
        }
        return $model;
    }
}
