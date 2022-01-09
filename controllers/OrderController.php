<?php

namespace app\controllers;

use app\models\Brand;
use app\models\Client;
use app\models\CreateOrder;
use app\models\Kind;
use app\models\Sample;
use app\models\Service;
use app\models\User;
use Yii;
use app\models\Order;
use app\models\OrderSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
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
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => [User::ROLE_MANAGER],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => [User::ROLE_OPERATOR],
                    ],
                    [
                        'actions' => ['index', 'update',  'archive',
                            'ajax-get-equipment-kind', 'ajax-get-equipment-brand', 'ajax-get-equipment-sample',
                            'ajax-get-clients', 'ajax-get-services'],
                        'allow' => true,
                        'roles' => [User::ROLE_REPAIRER],
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
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }

    /**
     * @return string
     */
    public function actionArchive()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->searchArchive(Yii::$app->request->queryParams);

        return $this->render('archive', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CreateOrder();

        if ($model->load(Yii::$app->request->post()) && (($order = $model->add())!=null)) {
            Yii::$app->session->setFlash('print_order_id', $order->id);
            return $this->redirect(['index']);
        }
        $model->equipment_serial_number = uniqid('srv');
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Получить типы оборудования под jquery autocomplete
     * @param $term
     * @return array[]|\string[][]
     */
    public function actionAjaxGetEquipmentKind($term)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data =  [];
        if ($term)
        {
            /**
             * @var $models Kind[]
             */
            $models = Kind::find()->where(['like', 'name', $term])->limit(20)->all();
            foreach ($models as $model)
            {
                $data[] = ['id' => $model->id, 'label' => $model->name];
            }
        }
        return $data;
    }

    /**
     * @param $term
     * @return array[]|\string[][]
     */
    public function actionAjaxGetEquipmentBrand($term)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = [];
        if ($term)
        {
            /**
             * @var $models Brand[]
             */
            $models = Brand::find()->where(['like', 'name', $term])->limit(20)->all();
            foreach ($models as $model)
            {
                $data[] = ['id' => $model->id, 'label' => $model->name];
            }
        }
        return $data;
    }

    /**
     * @param $term
     * @param $brand_id
     * @return array[]
     */
    public function actionAjaxGetEquipmentSample($term, $brand_id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = [];
        if ($term)
        {
            /**
             * @var $models Sample[]
             */
            $models = Sample::find()->where(['like', 'name', $term])
                ->andWhere(['brand_id' => $brand_id])->limit(20)->all();
            foreach ($models as $model)
            {
                $data[] = ['id' => $model->id, 'label' => $model->name];
            }
        }
        return $data;
    }

    /**
     * Получить клиентов под jquery autocomplete
     * @param $term
     * @return array[]|\string[][]
     */
    public function actionAjaxGetClients($term): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = [];
        if ($term)
        {
            /**
             * @var $models Client[]
             */
            $models = Client::find()->where(['like', 'fio', $term])->limit(20)->all();
            foreach ($models as $model)
            {
                $data[] = [
                    'id' => $model->id,
                    'fio' => $model->fio,
                    'label' => $model->fio. ' '. $model->phoneFormat,
                    'phone' => $model->phone,
                    'comment' => $model->comment
                ];
            }
        }
        return $data;
    }

    /**
     * @param $term
     * @return array
     */
    public function actionAjaxGetServices($term): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = [];
        if ($term)
        {
            /**
             * @var $models Service[]
             */
            $models = Service::find()->where(['like', 'name', $term])->limit(20)->all();
            foreach ($models as $model)
            {
                $data[] = [
                    'id' => $model->id,
                    'name' => $model->name,
                    'label' => $model->name. ' ('. $model->guarantee. ') '. $model->price,
                    'guarantee' => $model->guarantee,
                    'price' => $model->price
                ];
            }
        }
        return $data;
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (Yii::$app->request->post('print_act')) {
                Yii::$app->session->setFlash('print_act', $model->id);
            }
            return $this->redirect(['index' ]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
