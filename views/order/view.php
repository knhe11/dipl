<?php
/* @var $this yii\web\View */
/* @var $model app\models\OrderList */
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