<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property int $id
 * @property string|null $created_at
 * @property string|null $hired_at
 * @property string|null $closed_at
 * @property int $equipment_id
 * @property int $client_id
 * @property int $manager_id
 * @property int|null $master_id
 * @property int|null $status
 * @property int|null $placement
 * @property string|null $problems
 * @property string|null $kit
 * @property float|null $prepayment
 * @property float|null $cost
 * @property string|null $comment
 * @property string|null $conclusion
 * @property string|null $recommendation
 * @property string|null $services -- json данные, услуги
 *
 * @property-read  Client $client
 * @property-read  Equipment $equipment
 * @property-read  User $manager
 *
 * @property-read  string $statusLabel
 * @property-read  string $statusColor
 *
 * @property-read  array $service
 *
 */
class Order extends \yii\db\ActiveRecord
{

    const PLACEMENT_OFFICE = 1;
    const PLACEMENT_CLIENT = 2;

    const STATUS_START        = 1;
    const STATUS_RUNNING      = 2;
    const STATUS_WAITING      = 3;
    const STATUS_COMPLETE     = 4;
    const STATUS_INCOMPLETE   = 5;
    const STATUS_CLOSE_PASSED = 10;
    const STATUS_CLOSE_BOUGHT = 11;

    private bool $_service_set = false;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%order}}';
    }

    /**
     * @param array $arr
     */
    public function setService(array $arr)
    {
        $data = [];
        foreach ($arr as $item)
        {
            $data[] = $item;
        }
        $this->services = Json::encode($data);
        $this->_service_set = true;
    }

    /**
     * @return array|mixed|null
     */
    public function getService()
    {
        return ($this->services) ? Json::decode($this->services) : [];
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
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['created_at', 'hired_at', 'closed_at', 'service'], 'safe'],
            [['equipment_id', 'client_id'], 'required'],
            [['equipment_id', 'client_id', 'manager_id', 'master_id', 'status', 'placement'], 'integer'],
            [['problems', 'comment'], 'string'],
            [['prepayment', 'cost'], 'number'],
            [['kit', 'conclusion', 'recommendation'], 'string', 'max' => 255],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['client_id' => 'id']],
            [['equipment_id'], 'exist', 'skipOnError' => true, 'targetClass' => Equipment::class, 'targetAttribute' => ['equipment_id' => 'id']],
            [['manager_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['manager_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'created_at' => 'Создан',
            'hired_at' => 'Hired At',
            'closed_at' => 'Closed At',
            'equipment_id' => 'Equipment ID',
            'client_id' => 'Client ID',
            'manager_id' => 'Менеджер',
            'master_id' => 'Мастер',
            'status' => 'Status',
            'placement' => 'Placement',
            'problems' => 'Problems',
            'kit' => 'Комплектация',
            'prepayment' => 'Предоплата',
            'cost' => 'Стоимость',
            'comment' => 'Примечания',
            'conclusion' => 'Заключение',
            'recommendation' => 'Рекомендация',

            'equipment_kind' => 'Вид техники',
            'equipment_brand' => 'Производитель',
            'equipment_sample' => 'Модель',
            'equipment_serial_number' => 'Серийный номер',

            'client_fio' => 'Клиент',
            'client_phone' => 'Телефон',

        ];
    }

    /**
     * @return string[]
     */
    public static function listStatus(): array
    {
        return [
            self::STATUS_START        => 'Принят в сервис',
            self::STATUS_RUNNING      => 'Принят в работу',
            self::STATUS_WAITING      => 'Ожидает запчасти',
            self::STATUS_COMPLETE     => 'Выполнен, ожидает клиента',
            self::STATUS_INCOMPLETE   => 'Не выполнен, ожидает клиента',
            self::STATUS_CLOSE_PASSED => 'Закрыт. Выдан клиенту',
            self::STATUS_CLOSE_BOUGHT => 'Закрыт. Куплен'
        ];
    }

    /**
     * @return string[]
     */
    public static function listColorStatus(): array
    {
        return [
            self::STATUS_START        => 'danger',
            self::STATUS_RUNNING      => '',
            self::STATUS_WAITING      => 'warning',
            self::STATUS_COMPLETE     => 'success',
            self::STATUS_INCOMPLETE   => 'info',
            self::STATUS_CLOSE_PASSED => '',
            self::STATUS_CLOSE_BOUGHT => 'info'
        ];
    }

    /**
     * @return mixed|null
     * @throws \Exception
     */
    public function getStatusColor()
    {
        return ArrayHelper::getValue(self::listColorStatus(), $this->status);
    }

    /**
     * @return mixed|null
     * @throws \Exception
     */
    public function getStatusLabel()
    {
        return ArrayHelper::getValue(self::listStatus(), $this->status);
    }

    /**
     * @return bool
     */
    public function isArchived(): bool
    {
        return $this->status >= self::STATUS_CLOSE_PASSED;
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }

    /**
     * Gets query for [[Equipment]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEquipment(): \yii\db\ActiveQuery
    {
        return $this->hasOne(Equipment::class, ['id' => 'equipment_id']);
    }

    /**
     * Gets query for [[Manager]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getManager(): \yii\db\ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'manager_id']);
    }

    /**
     * @return string[]
     */
    public static function listPlacement(): array
    {
        return [
            self::PLACEMENT_OFFICE => 'В офисе',
            self::PLACEMENT_CLIENT => 'У клиента'
        ];
    }



    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert): bool
    {
        if ($this->isNewRecord) {
            $this->status = self::STATUS_START;
            $this->manager_id = Yii::$app->user->id;
        }
        if (!$this->_service_set) // Немного колхоза, обнулить услуги, если не было установки
        {
            $this->services = null;
        }
        if ($this->isArchived()) {
            $this->closed_at = date('Y-m-d H:i:s');
        }

        return parent::beforeSave($insert);
    }

}
