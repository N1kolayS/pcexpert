<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%cat_service}}".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $sort
 *
 * @property-read  Service[] $services
 */
class CatService extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%cat_service}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['sort'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'sort' => 'Sort',
        ];
    }

    /**
     * Gets query for [[Services]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getServices(): \yii\db\ActiveQuery
    {
        return $this->hasMany(Service::class, ['category_id' => 'id']);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function listItems(): array
    {
        return self::find()->orderBy(['sort' => SORT_ASC])->all();
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        if ($this->isNewRecord)
        {
            $max = self::find()->max('sort');
            $this->sort = ($max) ? $max+1 : 0;
        }
        return parent::beforeSave($insert);
    }
}
