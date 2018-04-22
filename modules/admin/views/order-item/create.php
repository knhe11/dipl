<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\OrderItem */

$this->title = 'Добавить новую деталь';
$this->params['breadcrumbs'][] = ['label' => 'Добавление деталей', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
