<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "format_list".
 *
 * @property int $id
 * @property int $width_list Ширина
 * @property int $height_list Длина
 * @property int $width_disk Длина
 */
class FormatList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'format_list';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['width_list', 'height_list', 'width_disk', 'edge_plate'], 'required'],
            [['width_list', 'height_list', 'width_disk', 'edge_plate'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'height_list' => 'Длина',
            'width_list' => 'Ширина',
            'width_disk' => 'Ширина диска',
            'edge_plate' => 'Кромка листа',
        ];
    }

    public static function getLimitParams()
    {
        $maxHeight = self::find()->orderBy('height_list DESC')->one();
        $maxWidth = self::find()->orderBy('width_list DESC')->one();

        if ($maxHeight && $maxWidth) {
            return [
                'maxHeight' => [
                    'width' => $maxHeight->width_list,
                    'height' => $maxHeight->height_list,
                ],
                'maxWidth' => [
                    'width' => $maxWidth->width_list,
                    'height' => $maxWidth->height_list,
                ],
            ];
        } else {
            return false;
        }
    }
}
