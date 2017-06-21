<?php

use yii\db\Migration;

/**
 * Handles the creation of table `record`.
 */
class m170621_084524_create_record_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('record', [
            'id' => $this->primaryKey(),
            'qendra_id' => 'VARCHAR(255) NOT NULL',
            'emertimi' => 'VARCHAR(255) NOT NULL',
            'date_lindja' => 'VARCHAR(255) NOT NULL',
            'nr_rendor' => 'INT(11) NOT NULL',
            'pranishem' => 'TINYINT(1) NOT NULL DEFAULT 0'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('record');
    }
}
