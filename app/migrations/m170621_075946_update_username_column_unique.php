<?php

use yii\db\Migration;

class m170621_075946_update_username_column_unique extends Migration
{
    public function safeUp()
    {
        $this->alterColumn('user', 'username', 'VARCHAR(255) NOT NULL UNIQUE');
    }

    public function safeDown()
    {
        echo "m170621_075946_update_username_column_unique cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170621_075946_update_username_column_unique cannot be reverted.\n";

        return false;
    }
    */
}
