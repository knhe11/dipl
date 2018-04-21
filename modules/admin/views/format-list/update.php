<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FormatList */

$this->title = 'Update Format List: {nameAttribute}';
$this->params['breadcrumbs'][] = ['label' => 'Format Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="format-list-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
