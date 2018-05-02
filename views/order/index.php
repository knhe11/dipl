<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
//use yii\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\modelsSearch\OrderList */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список заявок';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-item-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Новая заявка', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin()?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
            'columns' => [
                //['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'id',
                    'label' => 'Заявка',
                    'format' => 'html',
                    'options' => [
                        'width' => '80',
                    ],
                    'value' => function($data) {return '#' . $data->id;},
                ],
                [
                    'attribute' => 'id_format_list',
                    'label' => 'Формат листа',
                    'format' => 'html',
                    'value' => function($data) {return $data->formatList->nameFormatList;},
                ],
                [
                    'attribute' => 'count_list',
                    'label' => 'Кол-во листов',
                ],
                [
                    'attribute' => 'kim',
                    'label' => 'КИМ %',
                ],
                [
                    'attribute' => 'created_by',
                    'value' => function($data){return $data->creater->username;},
                    'filter' => false,
                ],
                [
                    'attribute' => 'created_at',
                    'value' => function($data){return date('d.m.Y H:i',$data->created_at);}
                ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {delete}',
                ],
            ],
        ]); ?>
    <?php Pjax::end()?>
</div>
