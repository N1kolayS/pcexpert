<?php


namespace app\controllers;


use app\models\Order;
use app\models\Template;
use app\models\User;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PrintController extends Controller
{

    public $layout = 'print';

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['order', 'close'],
                        'allow' => true,
                        'roles' => [User::ROLE_OPERATOR],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param int $id order id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionOrder(int $id): string
    {
        $model = $this->findModelOrder($id);
        $template = Template::findOrder();
        return $this->render($template->renderPath, [
            'model' => $model
        ]);
    }

    /**
     * @param int $id order id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionClose(int $id): string
    {
        $model = $this->findModelOrder($id);
        $template = Template::findClose();
        return $this->render($template->renderPath, [
            'model' => $model
        ]);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelOrder(int $id): Order
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}