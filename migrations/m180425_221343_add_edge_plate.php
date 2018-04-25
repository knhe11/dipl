<?php

use yii\db\Migration;

/**
 * Class m180425_221343_add_edge_plate
 */
class m180425_221343_add_edge_plate extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%format_list}}','edge_plate', $this->smallInteger(3)->notNull()->defaultValue(0)->comment('Кромка листа'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%format_list}}','edge_plate');
    }

}
