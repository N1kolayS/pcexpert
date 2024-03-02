<?php

namespace tests\unit\models;

use app\models\User;

class UserTest extends \Codeception\Test\Unit
{


    public function testFindUserByUsername()
    {
        expect_that($user = User::findByEmail('shayahmetov@gmail.com'));
        expect_not(User::findByEmail('wrong@gmail.com'));
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser($user)
    {
        $user = User::findByEmail('shayahmetov@gmail.com');


        expect_that($user->validatePassword('wrong_pass'));
        expect_not($user->validatePassword('123456'));        
    }

}
