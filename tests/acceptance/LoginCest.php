<?php

use app\tests\fixtures\UserFixture;

use yii\helpers\Url;

class LoginCest
{
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login_data.php',
            ],
        ];
    }

    public function _before(AcceptanceTester $I)
    {
        //  Check the content of fixtures in db
        $I->seeRecord(\app\models\User::class, ['email'=>'sfriesen@jenkins.info']);


    }

    public function ensureThatLoginWorks(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/login'));
        $I->see('PC Expert');

        $I->amGoingTo('try to login with correct credentials');
        $I->fillField('input[name="LoginForm[email]"]', 'sfriesen@jenkins.info');
        $I->fillField('input[name="LoginForm[password]"]', 'password_0');
        $I->click('login-button');
        $I->wait(2); // wait for button to be clicked

        $I->expectTo('see order page');
        $I->see('Панель управления');
    }
}
