<?php

use app\tests\fixtures\UserFixture;

class LoginFormCest
{

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


    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
    }




    protected function formParams($email, $password)
    {
        return [
            'LoginForm[email]' => $email,
            'LoginForm[password]' => $password,
        ];
    }

    public function checkEmpty(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('sfriesen@jenkins.info', ''));
        $I->see('Необходимо заполнить «Password»');
    }

    public function checkWrongPassword(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('admin', 'wrong'));
        $I->see('Incorrect username or password.');
    }

    public function checkInactiveAccount(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('test.test', 'Test1234'));
        $I->see('Incorrect username or password');
    }

    public function checkValidLogin(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('sfriesen@jenkins.info', 'password_0'));
        $I->see('erau', 'span');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Signup');
    }
}