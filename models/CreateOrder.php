<?php


namespace app\models;



use yii\base\Model;

/**
 * Class CreateOrder
 * @package app\models
 */
class CreateOrder extends Model
{
    public $client_id;
    public $client_fio;
    public $client_phone;
    public $client_comment;

    public $equipment_id;
    public $equipment_kind;
    public $equipment_brand;
    public $equipment_sample;
    public $equipment_serial_number;

    public $kit;
    public $problems;
    public $placement;
    public $prepayment;
    public $comment;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['client_fio', 'string', 'min' => 2, 'max' => 255],
            ['client_fio', 'trim'],
            ['client_fio', 'required'],

            ['client_phone', 'trim'],
            ['client_phone', 'required'],
            ['client_phone', 'is10NumbersOnly'],

            [['equipment_kind', 'equipment_brand', 'equipment_sample', 'equipment_serial_number' ], 'string', 'min' => 2, 'max' => 255],
            [['equipment_kind', 'equipment_brand', 'equipment_sample',  'problems' ], 'required'],

            [['client_id', 'equipment_id', 'placement'], 'integer'],

            [['comment', 'prepayment', 'client_comment'], 'string'],
            [['kit', 'problems'], 'safe'],

        ];
    }

    /**
     * @return bool
     */
    public function beforeValidate() {
        $this->client_phone = str_replace('-', null, $this->client_phone);
        return parent::beforeValidate();
    }

    /**
     * @param $attribute
     */
    public function is10NumbersOnly($attribute)
    {
        if (!preg_match('/^[0-9]{10}$/', $this->$attribute)) {
            $this->addError($attribute, 'Телефон должен состоять из 10 цифр');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'client_fio' => 'ФИО',
            'client_phone' => 'Телефон',
            'client_comment' => 'Комментарий',
            'problems' => 'Проблемы',
            'kit' => 'Комплектация',
            'comment' => 'Комментарий',

            'equipment_kind' => 'Вид техники',
            'equipment_brand' => 'Производитель',
            'equipment_sample' => 'Модель',
            'equipment_serial_number' => 'Серийный номер',
        ];
    }

    /**
     * @return Order|null
     */
    public function add()
    {

        if (!$this->validate()) {
            return null;
        }
        if (($client = $this->addClient()) === false)
        {
            return null;
        }
        if (($equipment = $this->addEquipment($client)) === false)
        {
            return null;
        }

        $order = new Order();
        $order->equipment_id = $equipment->id;
        $order->client_id = $client->id;
        $order->comment = $this->comment;
        $order->problems = implode(', ', $this->problems);
        $order->kit = ($this->kit) ? implode(', ', $this->kit) : '';
        $order->prepayment = $this->prepayment;
        $order->placement = $this->placement;
        if ($order->save())
        {
            return $order;
        }
        else {
            $this->addErrors($order->errors);
            return null;
        }

    }

    /**
     * Создать клиента  и(или) вернуть модель найденного
     * @return Client|bool
     */
    private function addClient()
    {
        $client = Client::findOne($this->client_id);
        if (!$client) {
            $client = new Client();
            $client->fio = $this->client_fio;
            $client->phone = $this->client_phone;
            $client->comment = $this->client_comment;
            if ($client->save())
            {
                return $client;
            }
            else {
                return false;
            }
        }
        return $client;
    }

    /**
     * Создать Оборудование и(или) вернуть модель найденного
     * @param Client $client
     * @return Equipment|bool|null
     */
    private function addEquipment(Client $client)
    {
        $equipment = Equipment::findOne($this->equipment_id);
        if ((!$equipment)) {
            $equipment = new Equipment();
            $equipment->kind = $this->equipment_kind;
            $equipment->brand = $this->equipment_brand;
            $equipment->sample = $this->equipment_sample;
            $equipment->serial_number = $this->equipment_serial_number;
            $equipment->client_id = $client->id;
            if ($equipment->save())
            {
                return $equipment;
            }
            else {
                return  false;
            }
        }
        return $equipment;
    }
}