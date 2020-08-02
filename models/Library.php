<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "library".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $type
 *
 * @property string $typeLabel
 */
class Library extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%library}}';
    }

    const TYPE_KIT = 1;
    const TYPE_PROBLEM = 2;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'name'], 'required'],
            [['type'], 'integer'],
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
            'name' => 'Название',
            'type' => 'Тип',
        ];
    }

    /**
     * @return string[]
     */
    public static function listTypes()
    {
        return [
            self::TYPE_KIT => 'Комплектация',
            self::TYPE_PROBLEM => 'Проблемы',
        ];
    }

    /**
     * Список несиправностей
     * @return Library[]|\yii\db\ActiveRecord[]
     */
    public static function listProblems()
    {
        return self::find()->where(['type' => self::TYPE_PROBLEM])->all();
    }

    /**
     * Список комплектов
     * @return Library[]|\yii\db\ActiveRecord[]
     */
    public static function listKits()
    {
        return self::find()->where(['type' => self::TYPE_KIT])->all();
    }

    /**
     * @return mixed|null
     * @throws \Exception
     */
    public function getTypeLabel()
    {
        return ArrayHelper::getValue(self::listTypes(), $this->type);
    }
}
