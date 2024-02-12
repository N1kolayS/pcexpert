<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%client}}".
 *
 * @property int $id
 * @property string|null $created_at
 * @property int $creator_id
 * @property string|null $fio
 * @property string|null $phone
 * @property int|null $status
 * @property int|null $rating
 * @property string|null $comment
 * @property int|null $legal
 *
 * @property-read  User $creator
 * @property-read  string $phoneFormat - отформатированный номер телефон 8 (123) 456-7890
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%client}}';
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
     * @return string
     */
    public function getPhoneFormat(): string
    {
        $area =   substr($this->phone,0,3);
        $prefix = substr($this->phone,3,3);
        $number = substr($this->phone,6);
        return "8 ($area) $prefix-$number";
    }

    /**
     * @return bool
     */
    public function beforeValidate(): bool
    {
        $this->phone = str_replace('-', null, $this->phone);
        return parent::beforeValidate();
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['created_at'], 'safe'],
            [['fio', 'phone'], 'required'],
            [['creator_id', 'status', 'rating', 'legal'], 'integer'],
            [['comment'], 'string'],
            [['fio', 'phone'], 'string', 'max' => 255],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
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
            'creator_id' => 'Создан',
            'fio' => 'ФИО',
            'phone' => 'Телефон',
            'status' => 'Статус',
            'rating' => 'Rating',
            'comment' => 'Comment',
            'legal' => 'Legal',
        ];
    }

    /**
     * Gets query for [[Creator]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreator(): \yii\db\ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'creator_id']);
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        if ($this->isNewRecord) {
            $this->creator_id = Yii::$app->user->id;
        }
        return parent::beforeSave($insert);
    }
}
