<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $model app\models\OrderItem */

?>


    <tr>
        <td>
            <?=Html::activeTextInput($model,'width_item[]',[
                'class' => 'form-control',
                'data-width' => true,
            ])?>
        </td>
        <td>
            <?=Html::activeTextInput($model,'height_item[]',[
                'class' => "form-control",
                'data-height' => true,
            ]) ?>
        </td>
        <td>
            <?=Html::activeTextInput($model,'count_item[]',[
                'class' => "form-control",

            ])?>
        </td>
        <td><?=Html::a('<i class="glyphicon glyphicon-remove"></i>','#',['onclick' => 'rmItem(this,event)']);?></td>
    </tr>





