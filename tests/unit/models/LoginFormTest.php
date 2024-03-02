<?php

namespace tests\unit\models;

use app\models\LoginForm;
use app\tests\fixtures\UserFixture;


class LoginFormTest extends \Codeception\Test\Unit
{
    private $model;

    /**
     * Load fixtures before db transaction begin
     * Called in _before()
     * @see \Codeception\Module\Yii2::_before()
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login_data.php',
            ],
        ];
    }


    protected function _after()
    {
        \Yii::$app->user->logout();
    }

    public function testLoginNoUser()
    {
        $this->model = new LoginForm([
            'email' => 'not_existing_username',
            'password' => 'not_existing_password',
        ]);

        expect_not($this->model->login());
        expect_that(\Yii::$app->user->isGuest);
    }

    public function testLoginWrongPassword()
    {
        $this->model = new LoginForm([
            'email' => 'sfriesen@jenkins.info',
            'password' => 'wrong_pass',
        ]);

        expect_not($this->model->login());
        expect_that(\Yii::$app->user->isGuest);
        expect($this->model->errors)->hasKey('password');
    }

    public function testLoginCorrect()
    {
        $this->model = new LoginForm([
            'email' => 'sfriesen@jenkins.info',
            'password' => 'password_0',
        ]);

        expect_that($this->model->login());
        expect_not(\Yii::$app->user->isGuest);
        expect($this->model->errors)->hasntKey('password');
    }

}
