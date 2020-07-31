<?php

namespace app\models;

use Yii;

/**
 * Виды техники. Например: принтер, компьютер, монитор
 * This is the model class for table "{{%kind}}".
 *
 * @property int $id
 * @property string|null $name
 */
class Kind extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%kind}}';
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Получить вид техники по имени,
     * в случае отсутствия такого имени, создать вид техники
     * @param $name
     * @return Kind|null
     */
    public static function getByName($name)
    {
        $model = self::findOne(['name' => $name]);
        if (!$model)
        {
            $model = new Kind();
            $model->name = $name;
            $model->save();
        }
        return $model;
    }
}
