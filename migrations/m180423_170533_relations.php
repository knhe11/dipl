<?php

use yii\db\Migration;

/**
 * Class m180423_170533_relations
 */
class m180423_170533_relations extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addForeignKey('fk-order_list-order_list','{{%order_list}}','id_format_list','{{%format_list}}','id');
        $this->addForeignKey('fk-order_item-id_order','{{%order_item}}','id_order','{{%order_list}}','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-order_list-order_list','{{%order_list}}');
        $this->dropForeignKey('fk-order_item-id_order','{{%order_item}}');
    }
}
