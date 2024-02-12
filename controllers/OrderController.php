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
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
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
    public function actionArchive(): string
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->searchArchive(Yii::$app->request->queryParams);

        return $this->render('archive', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @return string|Response
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
     * @param string $term
     * @return array[]
     */
    public function actionAjaxGetEquipmentKind(string $term): array
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
     * @param string $term
     * @return array[]
     */
    public function actionAjaxGetEquipmentBrand(string $term): array
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
     * @param string $term
     * @param int $brand_id
     * @return array
     */
    public function actionAjaxGetEquipmentSample(string $term, int $brand_id): array
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
     * @param string $term
     * @return array[]|\string[][]
     */
    public function actionAjaxGetClients(string $term): array
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
     * @param string $term
     * @return array
     */
    public function actionAjaxGetServices(string $term): array
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
     * @param int $id
     * @return string|Response
     * @throws NotFoundHttpException
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
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Order
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
