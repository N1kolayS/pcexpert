<?php


namespace app\models;


use phpDocumentor\Reflection\DocBlock\Tags\Throws;
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

    public $complect;
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

        ];
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
            'complect' => 'Комплектация',
            'comment' => 'Комментарий'
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
        $order->problems = $this->problems;
        $order->complect = $this->complect;
        $order->prepayment = $this->prepayment;
        $order->placement = $this->placement;

        return $order->save() ? $order : null;

    }

    /**
     * Создать клиента или вернуть модель найденного
     * @return Client|bool
     */
    private function addClient()
    {
        $client = Client::findOne($this->client_id);
        if (!$client) {
            $client = new Client();
            $client->setAttributes([
                'fio' => $this->client_fio,
                'phone' => $this->client_phone,
                'comment' => $this->client_comment
                ]);
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
     * Создать Оборудование или вернуть модель найденного
     * @param Client $client
     * @return Equipment|bool|null
     */
    private function addEquipment(Client $client)
    {
        $equipment = Equipment::findOne($this->equipment_id);
        if ((!$equipment)&&($client)) {
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