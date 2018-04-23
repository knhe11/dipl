<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_item".
 *
 * @property int $id
 * @property int $id_order Заказ
 * @property int $width_item Ширина детали
 * @property int $height_item Длина детали
 * @property int $count_item Кол-во
 *
 * @property OrderList $order
 */
class OrderItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_order', 'width_item', 'height_item', 'count_item'], 'required'],
            [['id_order', 'width_item', 'height_item', 'count_item'], 'integer'],
            [['id_order'], 'exist', 'skipOnError' => true, 'targetClass' => OrderList::className(), 'targetAttribute' => ['id_order' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_order' => 'Заказ',
            'width_item' => 'Ширина детали',
            'height_item' => 'Длина детали',
            'count_item' => 'Кол-во',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(OrderList::className(), ['id' => 'id_order']);
    }
}
