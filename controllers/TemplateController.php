<?php


namespace app\controllers;


use app\models\Template;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;

class TemplateController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['order', 'close'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
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