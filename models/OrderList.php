<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_list".
 *
 * @property int $id
 * @property int $id_format_list Формат листа
 * @property int $count_list Кол-во листов
 * @property double $kim Коэффициент использования матералов
 * @property int $created_by Пользователь
 * @property int $created_at Дата создания
 *
 * @property OrderItem[] $orderItems
 * @property FormatList $formatList
 */
class OrderList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_format_list'], 'required'],
            [['id_format_list', 'count_list', 'created_by', 'created_at'], 'integer'],
            [['kim'], 'number'],
            [['id_format_list'], 'exist', 'skipOnError' => true, 'targetClass' => FormatList::className(), 'targetAttribute' => ['id_format_list' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_format_list' => 'Формат листа',
            'count_list' => 'Кол-во листов',
            'kim' => 'Коэффициент использования материалов',
            'created_by' => 'Пользователь',
            'created_at' => 'Дата создания',
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->created_at = time();
            $this->created_by = Yii::$app->user->id;
        }

        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['id_order' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFormatList()
    {
        return $this->hasOne(FormatList::className(), ['id' => 'id_format_list']);
    }
}
