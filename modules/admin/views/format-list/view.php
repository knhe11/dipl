<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\FormatList */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Format Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="format-list-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить этот формат?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'width_list',
            'height_list',
            'width_disk',
        ],
    ]) ?>

</div>
