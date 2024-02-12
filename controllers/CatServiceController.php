<?php

namespace app\controllers;

use app\models\User;
use Yii;
use app\models\CatService;
use app\models\CatServiceSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use richardfan\sortable\SortableAction;

/**
 * CatServiceController implements the CRUD actions for CatService model.
 */
class CatServiceController extends Controller
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
                        'actions' => ['index', 'update', 'create', 'delete'],
                        'allow' => true,
                        'roles' => [User::ROLE_MANAGER],
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
     * @return array|array[]
     */
    public function actions(): array
    {
        return [
            'sortItem' => [
                'class' => SortableAction::class,
                'activeRecordClassName' => CatService::class,
                'orderColumn' => 'sort',
            ],

        ];
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new CatServiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new CatService();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     * @return \yii\web\Response
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
     * @param int $id
     * @return CatService
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): CatService
    {
        if (($model = CatService::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
