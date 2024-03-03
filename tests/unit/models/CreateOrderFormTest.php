<?php

namespace tests\unit\models;


use app\models\CreateOrder;
use app\models\User;
use app\tests\fixtures\OrderFixture;
use app\tests\fixtures\UserFixture;

class CreateOrderFormTest extends \Codeception\Test\Unit
{

    public function testCreateSuccess()
    {
        $this->model = new CreateOrder();
        expect_that($this->model->load([
            'client_fio' => 'Test Client',
            'client_phone' => '89613603024',
            'equipment_kind' => 'Ноутбук',
            'equipment_brand' => 'Asus',
            'equipment_sample' => 'A50',
            'equipment_serial_number' => 'serial_number00',
            'problems' => ['Some problem 1', 'Any problem']
        ], ''));
        //expect_that($this->model->add());

    }
}