<?php

namespace app\commands;


use app\models\User;
use Yii;
use yii\console\Controller;

/**
 * Команды инициализации, при первом запусуке приложения
 * Первым запускаем RBAC, он создает роли пользователей
 * Далее создаем пользователя, с правами администратора по умолчанию
 * Class InitController
 * @package console\controllers
 */
class InitController extends Controller
{
    /**
     * Иерархичное назанчение прав
     * Администратор включает права Менеджера и Пользователя
     * Менеджер включает права Пользователя
     * @throws \yii\base\Exception
     * @throws \Exception
     */
    public function actionStart()
    {
        Yii::$app->runAction('migrate', ['migrationPath' => '@yii/rbac/migrations/']);

        Yii::$app->authManager->removeAll();

        $role = Yii::$app->authManager->createRole(User::ROLE_ADMIN);
        $role->description = 'Администратор';
        Yii::$app->authManager->add($role);

        $role = Yii::$app->authManager->createRole(User::ROLE_MANAGER);
        $role->description = 'Менеджер';
        Yii::$app->authManager->add($role);

        $role = Yii::$app->authManager->createRole(User::ROLE_OPERATOR);
        $role->description = 'Оператор';
        Yii::$app->authManager->add($role);

        $role = Yii::$app->authManager->createRole(User::ROLE_REPAIRER);
        $role->description = 'Мастер';
        Yii::$app->authManager->add($role);

        $role = Yii::$app->authManager->createRole(User::ROLE_DEFAULT);
        $role->description = 'Пользователь';
        Yii::$app->authManager->add($role);

        // Implement
        $role_admin = Yii::$app->authManager->getRole(User::ROLE_ADMIN);
        $role_manager = Yii::$app->authManager->getRole(User::ROLE_MANAGER);
        $role_operator = Yii::$app->authManager->getRole(User::ROLE_OPERATOR);
        $role_repairer = Yii::$app->authManager->getRole(User::ROLE_REPAIRER);
        $role_user = Yii::$app->authManager->getRole(User::ROLE_DEFAULT);
        Yii::$app->authManager->addChild($role_admin, $role_manager);
        Yii::$app->authManager->addChild($role_manager, $role_operator);
        Yii::$app->authManager->addChild($role_operator, $role_repairer);
        Yii::$app->authManager->addChild($role_repairer, $role_user);
        /* */
        echo 'Управление правами успешно создано'. PHP_EOL;
        echo 'Запустить "yii user/create Имя пароль email" для создания пользователя'. PHP_EOL;
    }


}
