<?php

use yii\db\Migration;

class m170620_203608_add_default_users_records extends Migration
{
    public function safeUp()
    {   
        $password1 = "grid_application123";
        $salt1 = crypt("$6$" . rand(0, 99999999999), "$6$" . rand(0, 99999999999));
        $this->insert('user', [
            'username' => 'perdoruesi1',
            'hashed_password' => crypt($password1, $salt1),
            'hashed_salt' => $salt1
        ]);

        $password2 = "grid_application514";
        $salt2 = crypt("$6$" . rand(0, 99999999999), "$6$" . rand(0, 99999999999));
        $this->insert('user', [
            'username' => 'perdoruesi2',
            'hashed_password' => crypt($password2, $salt2),
            'hashed_salt' => $salt2
        ]);

        $password3 = "grid_application227";
        $salt3 = crypt("$6$" . rand(0, 99999999999), "$6$" . rand(0, 99999999999));
        $this->insert('user', [
            'username' => 'perdoruesi3',
            'hashed_password' => crypt($password3, $salt3),
            'hashed_salt' => $salt3
        ]);

        $password4 = "grid_application246";
        $salt4 = crypt("$6$" . rand(0, 99999999999), "$6$" . rand(0, 99999999999));
        $this->insert('user', [
            'username' => 'perdoruesi4',
            'hashed_password' => crypt($password4, $salt4),
            'hashed_salt' => $salt4
        ]);
    }

    public function safeDown()
    {
        echo "m170620_203608_add_default_users_records cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170620_203608_add_default_users_records cannot be reverted.\n";

        return false;
    }
    */
}
