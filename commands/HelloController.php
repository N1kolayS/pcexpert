<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Order;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HelloController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";

        return ExitCode::OK;
    }

    public function actionTestDate()
    {
        $previousMonday = new \DateTime('Monday ago');
        print_r($previousMonday->format('Y-m-d')).PHP_EOL;
        $orders = Order::find()->where(['DATE(created_at)' => $previousMonday->format('Y-m-d')])->sum('cost');
        echo PHP_EOL;
        print_r($orders);
        echo PHP_EOL;

        $currentMonday = new \DateTime('Monday this week');
        print_r($currentMonday->format('Y-m-d')).PHP_EOL;
    }
}
