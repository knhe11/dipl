<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="col-lg-12">
        <div class="headinf">
            <div class="jumbotron">
                <h1>Оптимизатор раскроя</h1>
                <p class="lead">Приложение расчитывает оптимальный раскрой листового материала</p>
            </div>
        </div>  
        <div class="body-content">

            <div class="row">
                <div class="col-lg-3">
                    <h2 align="center">Рабочее меню</h2>
                        <p><?=Html::a('Перейти в редактор формата',['/admin/format-list/index'],['class'=>'btn btn-success btn-sm btn-block', 'style'=>'padding-top: 16px; padding-bottom: 16px; font-size: 17px; margin-top: 30px; margin-bottom: 30px']);?></p>
                        <p><?=Html::a('Список заявок на раскрой',['/admin/order-item/index'],['class'=>'btn btn-success btn-sm btn-block', 'style'=>'padding-top: 16px; padding-bottom: 16px; font-size: 17px; margin-top: 30px; margin-bottom: 30px;']);?></p>            
                        <p><?=Html::a('Создать заявку на раскрой',['/admin/order/create'],['class'=>'btn btn-success btn-sm btn-block', 'style'=>'padding-top: 16px; padding-bottom: 16px; font-size: 17px; margin-top: 30px; margin-bottom: 30px;']);?></p> 
                        <p><?=Html::a('Удалить выбранную заявку',['/admin/order/create'],['class'=>'btn btn-success btn-sm btn-block','style'=>'padding-top: 16px; padding-bottom: 16px; font-size: 17px; margin-top: 30px; margin-bottom: 30px;']);?></p>      
                </div>
                <div class="col-lg-9">
                    <h2 align="center">Список заявок</h2>

                    
                </div>
            </div>

        </div>
</div>
