<?php

use yii\db\Migration;

class m160414_132636_init extends Migration
{
    public function up()
    {
        $this->execute(file_get_contents(Yii::getAlias('@app/dump/init.sql')));
    }

    public function down()
    {
        echo "m160414_132636_init cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
