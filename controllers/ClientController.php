<?php

namespace app\controllers;

use app\models\User;
use Yii;
use app\models\Client;
use app\models\ClientSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ClientController implements the CRUD actions for Client model.
 */
class ClientController extends Controller
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
                        'actions' => ['index', 'update', 'create', 'delete', 'ajax-get'],
                        'allow' => true,
                        'roles' => [User::ROLE_REPAIRER],
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
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new ClientSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @return string|Response
     */
    public function actionCreate()
    {
        $model = new Client();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Клиент успешно создан");
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Клиент успешно изменен");
            return $this->redirect(['index']);

        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete(int $id): Response
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param string $q
     * @return array[]
     */
    public function actionAjaxGet(string $q): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data =  [];
        if ($q)
        {
            /**
             * @var $models Client[]
             */
            $models = Client::find()->where(['like', 'fio', $q])->limit(20)->all();
            foreach ($models as $model)
            {
                $data[] = ['id' => $model->fio, 'text' => $model->fio];
            }
        }
        return ['results' => $data];
    }

    /**
     * Finds the Client model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Client the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Client
    {
        if (($model = Client::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
