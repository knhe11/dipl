<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FormatList */

$this->title = 'Изменние формата: ' . $model->height_list . ' ' . $model->width_list;
$this->params['breadcrumbs'][] = ['label' => 'Список форматов', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Изменение';
?>
<div class="format-list-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
