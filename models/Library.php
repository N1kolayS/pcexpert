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
    public static function tableName(): string
    {
        return '{{%library}}';
    }

    const TYPE_KIT = 1;
    const TYPE_PROBLEM = 2;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
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
    public function attributeLabels(): array
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
    public static function listTypes(): array
    {
        return [
            self::TYPE_KIT => 'Комплектация',
            self::TYPE_PROBLEM => 'Проблемы',
        ];
    }

    /**
     * Список неисправностей
     * @return Library[]|\yii\db\ActiveRecord[]
     */
    public static function listProblems(): array
    {
        return self::find()->where(['type' => self::TYPE_PROBLEM])->all();
    }

    /**
     * Список комплектов
     * @return Library[]|\yii\db\ActiveRecord[]
     */
    public static function listKits(): array
    {
        return self::find()->where(['type' => self::TYPE_KIT])->all();
    }

    /**
     * @return string|null
     * @throws \Exception
     */
    public function getTypeLabel(): ?string
    {
        return ArrayHelper::getValue(self::listTypes(), $this->type);
    }
}
