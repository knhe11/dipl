<?php
/* @var $this yii\web\View */
/* @var $model app\models\OrderList */

use yii\helpers\Html;
?>

<h1>Заявка №<?=$model->id?></h1>

<h3>Информация</h3>
<table class="table table-bordered">
    <tr>
        <th>Формат листа</th>
        <td><?=$model->formatList->nameFormatList?></td>
    </tr>
    <tr>
        <th>Кол-во листов</th>
        <td><?=$model->count_list?></td>
    </tr>
    <tr>
        <th>КИМ</th>
        <td><?=$model->kim?></td>
    </tr>
    <tr>
        <th>Создал</th>
        <td><?=$model->creater->username?></td>
    </tr>
    <tr>
        <th>Дата добавления</th>
        <td><?=date('d.m.Y H:i',$model->created_at)?></td>
    </tr>
</table>

<h3>Детали</h3>
<table class="table table-bordered">
    <tr>
        <th>Ширина детали</th>
        <th>Длина детали</th>
        <th>Кол-во</th>
    </tr>
    <?php foreach($model->orderItems as $item):?>
        <tr>
            <td><?=$item->width_item?></td>
            <td><?=$item->height_item?></td>
            <td><?=$item->count_item?></td>
        </tr>
    <?php endforeach;?>
</table>
<div class="page-break"></div>
<h3>Карты раскроя</h3>
<?php foreach($model->imagePages as $key => $image){
    echo Html::img($image,['class' => 'img-thumbnail']).'<br/><div class="page-break"></div>';
    //echo Html::a('Страница #'.$key,$image,['data-fancybox' => 'gallery',]) . '<br/>';
}?>