<?php
namespace app\models;
use Yii;
class OrderItem extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'order_item';
    }
    public function rules()
    {
        return [
            [['id_order', 'width_item', 'height_item', 'count_item'], 'required'],
            [['id_order', 'width_item', 'height_item', 'count_item'], 'integer'],
            [['id_order'], 'exist', 'skipOnError' => true, 'targetClass' => OrderList::className(),
                'targetAttribute' => ['id_order' => 'id']],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_order' => 'Заявка',
            'width_item' => 'Ширина детали',
            'height_item' => 'Длина детали',
            'count_item' => 'Кол-во',
        ];
    }
    public function getOrder()
    {
        return $this->hasOne(OrderList::className(), ['id' => 'id_order']);
    }
}
