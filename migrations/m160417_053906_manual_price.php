<?php

use yii\db\Migration;

class m160417_053906_manual_price extends Migration
{
    public function up()
    {
        $this->execute('ALTER TABLE products ADD manual_price FLOAT AFTER price');
    }

    public function down()
    {
        echo "m160417_053906_manual_price cannot be reverted.\n";

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
