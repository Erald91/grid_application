<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m170620_203031_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => 'VARCHAR(255) NOT NULL',
            'hashed_password' => 'VARCHAR(255) NOT NULL',
            'hashed_salt' => 'VARCHAR(255) NOT NULL',
            'is_admin' => 'TINYINT(1) DEFAULT 0'
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}
