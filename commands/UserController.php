<?php

namespace app\commands;

use app\models\User;
use Yii;
use yii\console\Controller;

/**
 * User controller
 */
class UserController extends Controller
{

    /**
     * Создать пароль
     * @param $username
     * @param $password
     * @param $email
     * @throws \Exception
     */
    public function actionCreate($username, $password, $email)
    {
        if (Yii::$app->authManager->getRole(User::ROLE_DEFAULT))
        {
            $user = new User();
            $user->username = $username;
            $user->email = $email;

            $user->setPassword($password);
            $user->generateAuthKey();
            $user->role = User::ROLE_ADMIN;
            $user->status = User::STATUS_ACTIVE;

            if ($user->save()) {
                Yii::$app->authManager->revokeAll($user->id);
                $userRole = Yii::$app->authManager->getRole(User::ROLE_ADMIN);
                Yii::$app->authManager->assign($userRole, $user->id);
                $user->updateAll(['role' => User::ROLE_ADMIN], $user->id);
                echo $user->username. PHP_EOL;

            }
            else
            {
                print_r($user->errors);
            }
        }
        else
        {
            echo 'Roles not assigned, run init/rbac '.PHP_EOL;
        }
    }

    /**
     * Изменить пароль
     * @param $email
     * @param $new_password
     */
    public function actionChangePass($email, $new_password)
    {
        $user = User::findByEmail($email);
        $user->setPassword($new_password);
        $user->save();
    }

    /**
     * @param $id
     * @param $role
     */
    public function actionAssignRole($id, $role)
    {
        $user = User::findOne($id);
        $user->role = $role;
        $user->save();
    }
}