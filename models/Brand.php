<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%brand}}".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property Sample[] $samples
 */
class Brand extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%brand}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Названия',
        ];
    }

    /**
     * Gets query for [[Samples]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSamples(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Sample::class, ['brand_id' => 'id']);
    }

    /**
     * Получить производителя по имени,
     * в случае отсутствия такого имени, создать производителя
     * @param string $name
     * @return Brand|null
     */
    public static function getByName(string $name): ?Brand
    {
        $model = self::findOne(['name' => $name]);
        if (!$model)
        {
            $model = new Brand();
            $model->name = $name;
            $model->save();
        }
        return $model;
    }

    /**
     * @return Brand[]|\yii\db\ActiveRecord[]
     */
    public static function listAll(): array
    {
        return self::find()->all();
    }
}
