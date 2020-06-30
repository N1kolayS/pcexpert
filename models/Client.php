<?php

namespace app\models;

use Yii;

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
 * @property User $creator
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%client}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'safe'],
            [['creator_id'], 'required'],
            [['creator_id', 'status', 'rating', 'legal'], 'integer'],
            [['comment'], 'string'],
            [['fio', 'phone'], 'string', 'max' => 255],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'creator_id' => 'Creator ID',
            'fio' => 'Fio',
            'phone' => 'Phone',
            'status' => 'Status',
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
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'creator_id']);
    }
}
