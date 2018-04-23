<?php

namespace app\controllers;

use app\models\FormatList;
use Yii;
use app\models\OrderItem;
use app\modelsSearch\OrderItem as OrderItemSearch;
use app\components\MainController;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\Response;
use yii\helpers\Json;

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
        $searchModel = new OrderItemSearch();
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