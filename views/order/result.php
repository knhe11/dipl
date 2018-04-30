<?php if(!empty($slabs_data)):?>
    <h3>Детали:</h3>
    <?php foreach($orderItems as $item):?>
        ширина - <?= $item[0]?><br/>
        высота - <?= $item[1]?><br/>
        кол-во - <?= $item[2]?><br/>
        <hr/>
    <?php endforeach;?>
    <h3>Результат расчета:</h3>
    <?php foreach ($slabs_data as $slab_data):?>
        <b>Используем плиту : </b> ID - <?=$slab_data['id'] ?><br/>
        <b>Параметры плиты : </b> <br/>
            длина - <?=$slab_data['height_list']?> мм.<br/>
            ширина - <?=$slab_data['width_list'] ?> мм.<br/>
        <b>Кромка плиты : </b> <?=$slab_data['edge_plate']?>мм.<br/>
        <b>Используется плит : </b><?=count($slab_data["pages"]);?><br/>
            <?php foreach ($slab_data["pages"] as $num_page => $page):?>
                Страница №<?=$num_page+1?>:<br/>

                <?php foreach($page as $row_num => $row):?>
                    Строка № <?=$row_num+1?><br/>
                    <?php foreach($row['elements'] as $el_num => $element):?>
                        Элемент <?=$el_num+1?>: <?=$element['width'] . 'x' . $element['height'];?><br/>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                <br/>
            <?php endforeach; ?>
        <br/>
        <hr/>
    <?php endforeach; ?>
<?php else:?>
    <div class="alert alert-danger" role="alert">Плиты под заданные части не найдены.</div>
<?php endif;?>
