<?php

use yii\db\Migration;

class m170621_180922_add_indexes_for_record_table extends Migration
{
    public function safeUp()
    {
        $this->createIndex('qendra_id_inx', 'record', 'qendra_id');
        $this->createIndex('emertimi_inx', 'record', 'emertimi');
        $this->createIndex('nr_rendor_inx', 'record', 'nr_rendor');
        $this->createIndex('pranishem_inx', 'record', 'pranishem');
    }

    public function safeDown()
    {
        echo "m170621_180922_add_indexes_for_record_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170621_180922_add_indexes_for_record_table cannot be reverted.\n";

        return false;
    }
    */
}
