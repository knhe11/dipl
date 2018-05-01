<?php

namespace app\controllers;

use app\models\FormatList;
use Yii;
use app\models\OrderItem;
use app\modelsSearch\OrderList as OrderListSearch;
use app\components\MainController;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\helpers\Json;
use app\helpers\Calculation;

class OrderController extends MainController
{

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create','add-item'],
                        'allow' => true,
                        'roles' => ['orderCreate']
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['ordersIndex']
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all FormatList models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderListSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $limitList = FormatList::getLimitParams();
        if ($limitList === false) {
            Yii::$app->session->setFlash('danger','Перед созданием заявки необходимо ввести размеры плит.');
            return $this->redirect(['/admin/format-list/index']);
        }
        // обработка данных
        if (Yii::$app->request->post()) {
            $orderItems = Yii::$app->request->post('OrderItem');
            $orderItems = array_map(null,$orderItems['width_item'],$orderItems['height_item'],$orderItems['count_item']);

            $calc = new Calculation();
            $calc->detal = $orderItems;
            $slab_data = $calc->init();

            return $this->render('result' , [
                'slab_data' => $slab_data,
                'orderItems' => $orderItems,
            ]);

        }

        return $this->render('create',['limitList' => Json::encode($limitList)]);
    }

    public function actionAddItem()
    {
        if (Yii::$app->request->isAjax) {
            $model = new OrderItem();
            $form = $this->renderAjax('_item_form',['model' => $model]);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'status' => true,
                'form' => $form,
            ];

        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

    }
}