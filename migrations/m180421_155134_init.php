<?php

use yii\db\Migration;

/**
 * Class m180421_155134_init
 */
class m180421_155134_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = '';

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        // таблица форматов
        $this->createTable('{{%format_list}}',[
            'id' => $this->primaryKey(),
            'width_list' => $this->integer(11)->notNull()->comment('Ширина'),
            'height_list' => $this->integer(11)->notNull()->comment('Длина'),
            'width_disk' => $this->integer(2)->notNull()->comment('Ширина диска'),
            'edge_plate' => $this->integer(2)->notNull()->comment('Кромка листа'),
        ],
        $tableOptions);
        // таблица заявки
        $this->createTable('{{%order_list}}',[
            'id' => $this->primaryKey(),
            'id_format_list' => $this->integer(11)->notNull()->comment('Формат листа'),
            'count_list' => $this->integer(11)->null()->comment('Кол-во листов'),
            'kim' => $this->float()->null()->comment('Коэффициент использования матералов'),
            'created_by' => $this->integer(11)->notNull()->comment('Пользователь'),            
            'created_at' => $this->integer(11)->notNull()->comment('Дата создания'),
        ],
        $tableOptions);

        //таблица деталей
        $this->createTable('{{%order_item}}',[
            'id' => $this->primaryKey(),
            'id_order' => $this->integer(11)->notNull()->comment('Заявка'),
            'width_item' => $this->integer(11)->notNull()->comment('Ширина детали'),
            'height_item' => $this->integer(11)->notNull()->comment('Длина детали'),          
            'count_item' => $this->integer(11)->notNull()->comment('Кол-во'),
        ],
        $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%format_list}}');
        $this->dropTable('{{%order_list}}');
        $this->dropTable('{{%order_item}}');
    }

}
