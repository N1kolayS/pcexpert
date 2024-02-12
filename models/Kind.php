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
    public static function tableName(): string
    {
        return '{{%kind}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'min' =>2, 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
        ];
    }

    /**
     * Получить вид техники по имени,
     * в случае отсутствия такого имени, создать вид техники
     * @param string $name
     * @return Kind|null
     */
    public static function getByName(string $name): ?Kind
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
