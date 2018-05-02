<?php
use yii\helpers\Html;
?>

<?php if(!empty($slab_data)):?>
    <?php if($slab_data["kim"] < Yii::$app->params['min_kim']):?>
        <div class="alert alert-danger" role="alert">
            КИМ составляет менее 85%, рекомендуем изменить размеры деталей.
        </div>
    <?php endif;?>

    <h3>Детали:</h3>
    <?php foreach($orderItems as $item):?>
        длина - <?= $item[1]?> мм.<br/>
        ширина - <?= $item[0]?> мм.<br/>
        кол-во - <?= $item[2]?> шт.<br/>
        <hr/>
    <?php endforeach;?>
    <h3>Результат расчета:</h3>

        <b>Используем плиту : </b> ID - <?=$slab_data['id'] ?><br/>
        <b>Параметры плиты : </b> <br/>
            длина - <?=$slab_data['height_list']?> мм.<br/>
            ширина - <?=$slab_data['width_list'] ?> мм.<br/>

        <b>Кромка плиты : </b> <?=$slab_data['edge_plate']?>мм.<br/>
        <b>Используется плит : </b><?=count($slab_data["pages"]);?> шт.<br/>
        <b>КИМ : </b><?=$slab_data["kim"];?><br/>
            <?php foreach ($slab_data["pages"] as $num_page => $page):?>
                <?php if (isset($slab_data['id_order'])):?>
                    <?=Html::a('Страница №' . ($num_page+1),
                        ['/uploads/'.$slab_data['id_order'] . '_page_' . $num_page . '.png'],
                        [
//                            'target' => '_blank',
                            'class' => 'prev',
                            'data-fancybox' => 'gallery',
                        ])?>:<br/>
                <?php else: ?>
                    Страница № <?=$num_page+1?>
                <?php endif;?>

                <?php foreach($page as $row_num => $row):?>
                    Уровень № <?=$row_num+1?><br/>
                    <?php foreach($row['elements'] as $el_num => $element):?>
                        Элемент <?=$el_num+1?>: <?=$element['height'] .'x' . $element['width'];?> мм.<br/>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <br/>
            <?php endforeach; ?>
        <br/>
        <hr/>

<?php else:?>
    <div class="alert alert-danger" role="alert">Плиты под заданные части не найдены.</div>
<?php endif;?>
