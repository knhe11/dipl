<?php
namespace app\helpers;

use app\models\FormatList;
use app\models\OrderItem;
use app\models\OrderList;
use yii\base\InvalidConfigException;
use Yii;

class Calculation
{
    public $detal;
    private $_slabs_data;
    private $_orderItems;
    private $_id_order;

    public function init()
    {
        if (!$this->detal)
            throw new InvalidConfigException('Не задан массив данных.');
        // сортировка по высоте
        $data_item_height = [];
        $orderItems = $this->detal;
        //Генерируем "определяющий" массив
        foreach($orderItems as $key=>$arr){
            $data_item_height[$key]=$arr[1];
        }
        array_multisort($data_item_height, SORT_DESC,SORT_NUMERIC, $orderItems);
        $this->_orderItems = $orderItems;
        // создадим массив только элементов
        $elements = [];
        $max_width = 0; // максимальная ширина элемента
        $max_height = 0; // максимальные длина элемента
        $area_elements = 0; // площадь всех элементов
        // 0 - width_item
        // 1 - height_item
        // 2 - count_item
        foreach($orderItems as $key => $params){
            if ($max_width < $params[0])
                $max_width = $params[0];
            if ($max_height < $params[1])
                $max_height = $params[1];
            $area_elements = $area_elements + $params[0] * $params[1] * $params[2];
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
                'width_disk' => $slab->width_disk,
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
                $avaliby_height = $slab_data['height_list'] - 2 * $slab_data['edge_plate'];
                foreach ($rows as $num_row => $row){
                    if ($avaliby_height > $row['max_height']) {
                        $avaliby_height = $avaliby_height - $row['max_height'];
                        $pages[$num_page][] = $row;
                        unset($rows[$num_row]);
                    }
                }
                $num_page++;
            }
            // расчет полезного коэффициента
            $slabs_data[$id_format_list]['kim'] = $num_page * $slab_data['height_list'] * $slab_data['width_list']  / $area_elements;
            // ищем у кого низкий КИМ
            if(!isset($kim) ||  ($kim > $slabs_data[$id_format_list]['kim'])) {
                $kim = $slabs_data[$id_format_list]['kim'];
                $nummin_kim = $id_format_list;
            }
            $slabs_data[$id_format_list]['pages'] = $pages;
        }

        $this->_slabs_data = $slabs_data[$nummin_kim];
        $this->saveData();
        $this->map();

        return $this->_slabs_data;
    }

    private function saveData()
    {
        $param = $this->_slabs_data;
        $order = new OrderList();
        $order->id_format_list = $param['id'];
        $order->count_list = count($param ['rows']);
        $order->kim = $param['kim'];
        if ($order->save()) {
            $this->_id_order = $order->id;
            foreach($this->_orderItems as $order_item) {
                $item = new OrderItem();
                $item->id_order = $order->id;
                // 0 - width_item
                // 1 - height_item
                // 2 - count_item
                $item->width_item = $order_item[0];
                $item->height_item = $order_item[1];
                $item->count_item = $order_item[2];
                $item->save();

            }
            $this->_slabs_data['id_order'] = $order->id;
        }

    }

    private function map()
    {
        $params = $this->_slabs_data;
        $diagramWidth = $params['width_list'];
        $diagramHeight = $params['height_list'];

        foreach($params['pages'] as $key => $page) {
            // создаем изображение
            $image = imageCreate($diagramWidth, $diagramHeight);
            $start_x = $params['edge_plate'];
            $start_y = $params['edge_plate'];

            // Регистрируем используемые цвета
            $colorBackgr       = imageColorAllocate($image, 192, 192, 192); // серый нерабочая кромка
            $colorForegr       = imageColorAllocate($image, 255, 255, 255); // белый рабочая площадь
            $colorGrid         = imageColorAllocate($image, 0, 0, 0); // черный
            $colorCross        = imageColorAllocate($image, 0, 0, 0);
            $colorPhysical     = imageColorAllocate($image, 0, 0, 255); // синий
            $colorEmotional    = imageColorAllocate($image, 255, 0, 0); // красный
            $colorIntellectual = imageColorAllocate($image, 0, 255, 0); // зеленый
            // шрифт
            $font_file = Yii::getAlias('@webroot') . '/fonts/arial.ttf';

            // заливаем цветом фона
            imageFilledRectangle($image, 0, 0, $diagramWidth, $diagramHeight, $colorBackgr);
            imageFilledRectangle($image, $params['edge_plate'], $params['edge_plate'], $diagramWidth - $params['edge_plate'], $diagramHeight - $params['edge_plate'], $colorForegr);
            // пробегаемся по строкам
            foreach ($page as $rows) {
                $start_x = $params['edge_plate'];
                // пробегаемся по элементам
                foreach($rows['elements'] as $element) {
                    imageFilledRectangle($image, $start_x, $start_y, $start_x + $element['width'], $start_y + $element['height'], $colorPhysical);
                    // подпись текста
                    imagefttext($image, 10, 0, $start_x + 2, $start_y + 15, $colorIntellectual, $font_file, $element['width'] . 'x' . $element['height']);

                    $start_x = $start_x + $element['width'] + $params['width_disk'];
                }
                $start_y = $rows['max_height'] + $params['width_disk'] + $params['edge_plate'];
            }
            if ($this->_id_order)
                $path = Yii::getAlias('@webroot') . '/uploads/'.$this->_id_order.'_page_'.$key.'.png' ;
            else
                $path = Yii::getAlias('@webroot') . '/uploads/tmp_'.$key.'.png' ;
            imagePNG($image,$path);
        }


//        foreach ($this->_slabs_data as $slab_data) {

//        }
    }
}