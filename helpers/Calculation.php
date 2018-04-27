<?php
namespace app\helpers;

use app\models\FormatList;

class Calculation
{
    public $detal;

    public function init()
    {
        // сортировка по высоте
        $data_item_height = [];
        $orderItems = $this->detal;
        //Генерируем "определяющий" массив
        foreach($orderItems as $key=>$arr){
            $data_item_height[$key]=$arr[1];
        }
        array_multisort($data_item_height, SORT_DESC,SORT_NUMERIC, $orderItems);

        // создадим массив только элементов
        $elements = [];
        $max_width = 0; // максимальная ширина элемента
        $max_height = 0; // максимальные длина элемента
        // 0 - width_item
        // 1 - height_item
        // 2 - count_item
        foreach($orderItems as $key => $params){
            if ($max_width < $params[0])
                $max_width = $params[0];
            if ($max_height < $params[1])
                $max_height = $params[1];
            while ($params[2] > 0) {
                $params[2]--;
                $elements[] = [
                    'width' => $params[0],
                    'height' => $params[1],
                ];
            }
        }

        // отбираем материал только подходящие по высоте
        $slabs = FormatList::find()
            ->where('(`height_list` - 2 * `edge_plate`) >= :max_height AND (`width_list` - 2 * `edge_plate`) >= :max_width',
                [
                    ':max_height' => $max_height,
                    ':max_width' => $max_width,
                ])
            ->all();

        $slabs_data = [];

        foreach($slabs as $slab) {
            $work_width = $slab->width_list - 2 * $slab->edge_plate;
            $rows_element = [];
            $num_row = 0;
            // формирование горизонтальных строк
            foreach ($elements as $element){
                if (!isset($rows_element[$num_row]['row_width'])) {
                    $rows_element[$num_row]['row_width'] = $element['width'];
                } else {
                    $add_el_width = $rows_element[$num_row]['row_width'] + $slab->width_disk + $element['width'];
                    // если есть превышение ширины плиты, то переходим на новую строку
                    if ($add_el_width > $work_width) {
                        $num_row++;
                        $rows_element[$num_row]['row_width'] = $element['width'];
                    } else {
                        $rows_element[$num_row]['row_width'] = $add_el_width;
                    }
                }
                if (!isset($rows_element[$num_row]['max_height'])) {
                    $rows_element[$num_row]['max_height'] = $element['height'];
                }
                $rows_element[$num_row]['elements'][] = $element;
            }

            $slabs_data[$slab->id] = [
                'id' => $slab->id,
                'edge_plate' => $slab->edge_plate,
                'height_list' => $slab->height_list,
                'width_list' => $slab->width_list,
                'rows' => $rows_element,
            ];
        }

        // создаем массив страниц
        foreach ($slabs_data as $id_format_list => $slab_data) {
            $pages = [];
            $num_page = 0;
            $rows = $slab_data['rows'];
            while (!empty($rows)) {
                $avaliby_height = $slab_data['height_list'] - 2*$slab_data['edge_plate'];
                foreach ($rows as $num_row => $row){
                    if ($avaliby_height > $row['max_height']) {
                        $avaliby_height = $avaliby_height - $row['max_height'];
                        $pages[$num_page][] = $row;
                        unset($rows[$num_row]);
                    }
                }
                $num_page++;
            }
            $slabs_data[$id_format_list]['pages'] = $pages;
        }

        return $slabs_data;
    }

    public function map()
    {

    }
}