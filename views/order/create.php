<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\models\FormatList;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\OrderList */

$this->title = 'Новая заявка';
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
    window.limit = $limitList;
JS;
//маркер конца строки, обязательно сразу, без пробелов и табуляции
$this->registerJs($script, yii\web\View::POS_END);

?>
<div class="row">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('Новая деталь',['/order/add-item'],['onclick' => 'addItem(this,event)','class' => 'btn btn-success'])?>
    <?php $form = ActiveForm::begin(['id' => 'new-order-form']); ?>
<br/>
    <table id="items-forms" class="table table-bordered">
        <thead>
            <tr>
                <th>Длина</th>
                <th>Ширина</th>
                <th>Кол-во</th>
                <th>Действие</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
        <div class="form-group">
            <?= Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Рассчитать', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>
