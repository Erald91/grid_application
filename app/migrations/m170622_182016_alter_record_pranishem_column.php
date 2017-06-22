<?php

use yii\db\Migration;

class m170622_182016_alter_record_pranishem_column extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('record', 'pranishem', 'SET("0", "1", "2", "3") NOT NULL');
    }

    public function safeDown()
    {
        echo "m170622_182016_alter_record_pranishem_column cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170622_182016_alter_record_pranishem_column cannot be reverted.\n";

        return false;
    }
    */
}
