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
    public static function tableName()
    {
        return '{{%brand}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
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
    public function getSamples()
    {
        return $this->hasMany(Sample::className(), ['brand_id' => 'id']);
    }

    /**
     * Получить производителя по имени,
     * в случае отсутствия такого имени, создать производителя
     * @param $name
     * @return Brand|null
     */
    public static function getByName($name)
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
    public static function listAll()
    {
        return self::find()->all();
    }
}
