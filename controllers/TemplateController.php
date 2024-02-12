<?php


namespace app\controllers;


use app\models\Template;
use app\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;

class TemplateController extends Controller
{

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
                        'roles' => [User::ROLE_ADMIN],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],

                ],
            ],
        ];
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionOrder()
    {
        $model = Template::findOrder();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Шаблон успешно изменен");
            return $this->refresh();
        }

        return $this->render('update', [
            'model' => $model,
        ]);

    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionClose()
    {
        $model = Template::findClose();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Шаблон успешно изменен");
            return $this->refresh();
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }
}