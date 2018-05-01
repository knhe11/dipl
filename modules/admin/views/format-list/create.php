<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FormatList */

$this->title = 'Новый формат листа';
$this->params['breadcrumbs'][] = ['label' => 'Редактор форматов листа', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="format-list-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
