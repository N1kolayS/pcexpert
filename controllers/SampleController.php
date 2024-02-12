<?php

namespace app\controllers;

use app\models\Brand;
use app\models\User;
use Yii;
use app\models\Sample;
use app\models\SampleSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * SampleController implements the CRUD actions for Sample model.
 */
class SampleController extends Controller
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
                        'actions' => ['index', 'update', 'create', 'delete', 'ajax-get-brand'],
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
        $searchModel = new SampleSearch();
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
        $model = new Sample();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Материал успешно изменен");
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
            Yii::$app->session->setFlash('success', "Материал успешно изменен");
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Варианты техники для Select2
     * @param string $q
     * @return array[]
     */
    public function actionAjaxGetBrand(string $q): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data =  [];
        if ($q)
        {
            /**
             * @var $models Brand[]
             */
            $models = Brand::find()->where(['like', 'name', $q])->limit(20)->all();
            foreach ($models as $model)
            {
                $data[] = ['id' => $model->id, 'text' => $model->name];
            }
        }
        return ['results' => $data];
    }

    /**
     * @param int $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete(int $id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Sample model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sample the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Sample
    {
        if (($model = Sample::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
