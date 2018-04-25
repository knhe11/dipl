<?php

namespace app\controllers;

use app\models\FormatList;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Yii;
use app\models\OrderItem;
use app\modelsSearch\OrderItem as OrderItemSearch;
use app\components\MainController;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
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
        // обработка данных
        if (Yii::$app->request->post()) {
            $orderItems = Yii::$app->request->post('OrderItem');
            $orderItems = array_map(null,$orderItems['width_item'],$orderItems['height_item'],$orderItems['count_item']);
            // сортировка по высоте
            $data_item_height = [];
            //Генерируем "определяющий" массив
            foreach($orderItems as $key=>$arr){
                $data_item_height[$key]=$arr[1];
            }
            array_multisort($data_item_height, SORT_DESC,SORT_NUMERIC, $orderItems);

            // создадим массив только элементов
            $elements = [];
            $max_width = 0; // максимальная ширина элемента
            $max_height = 0; // максимальные длина элемента
            // 0 - width_item
            // 1 - height_item
            // 2 - count_item
            foreach($orderItems as $key => $params){
                if ($max_width < $params[0])
                    $max_width = $params[0];
                if ($max_height < $params[1])
                    $max_height = $params[1];
                while ($params[2] > 0) {
                    $params[2]--;
                    $elements[] = [
                        'width' => $params[0],
                        'height' => $params[1],
                    ];
                }
            }
            // отбираем материал только подходящие по высоте
            $slabs = FormatList::find()
                ->where(['>=','height_list',$max_height])
                ->andWhere(['>=','width_list',$max_width])
                ->all();

            foreach($slabs as $slab) {
                $work_width = $slab->width_list - 2 * $slab->edge_plate;
                $rows_element = [];
                $num_row = 0;
                // формирование горизонтальных строк
                foreach ($elements as $element){
                    if (!isset($rows_element[$num_row]['row_width'])) {
                        $rows_element[$num_row]['row_width'] = $element['width'];
                    } else {
                        $add_el_width = $rows_element[$num_row]['row_width'] + $slab->width_disk + $element['width'];
                        // если есть превышение ширины плиты, то переходим на новую строку
                        if ($add_el_width > $work_width) {
                            $num_row++;
                            $rows_element[$num_row]['row_width'] = $element['width'];
                        } else {
                            $rows_element[$num_row]['row_width'] = $add_el_width;
                        }
                    }
                    if (!isset($rows_element[$num_row]['max_height'])) {
                        $rows_element[$num_row]['max_height'] = $element['height'];
                    }
                    $rows_element[$num_row]['rows'][] = $element;
                }

                $slabs_data[$slab->id] = [
                    'id' => $slab->id,
                    'height_list' => $slab->height_list,
                    'rows' => $rows_element,
                ];
            }

            // создаем массив страниц
            foreach ($slabs_data as $id_format_list => $slab_data) {
                $pages = [];
                $num_page = 0;
                $rows = $slab_data['rows'];
                while (!empty($rows)) {
                    $avaliby_height = $slab_data['height_list'];
                    foreach ($rows as $num_row => $row){
                        if ($avaliby_height > $row['max_height']){
                            $avaliby_height = $avaliby_height - $row['max_height'];
                            $pages[$num_page] = $row;
                            unset($rows[$num_row]);
                        }
                    }
                    $num_page++;
                }
                $slabs_data[$id_format_list]['page'] = $pages;
            }


            var_dump($slabs_data);
            exit;
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