<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FormatList */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="format-list-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'height_list')->textInput() ?>
    <?= $form->field($model, 'width_list')->textInput() ?>
    <?= $form->field($model, 'width_disk')->textInput() ?>
    <?= $form->field($model, 'edge_plate')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
