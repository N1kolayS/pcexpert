<?php


namespace app\models;


use yii\base\Model;

class CreateOrder extends Model
{

    public $client_fio;
    public $client_phone;
    public $client_comment;

    public $equipment_kind;
    public $equipment_brand;
    public $equipment_sample;
    public $serial_number;

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

        $order = new Order();
        $order->complect = $this->complect;


        return $order->save() ? $order : null;
    }
}