<?php

use yii\db\Migration;
use yii\db\Schema;

class m171009_192324_add_new_field_to_profile extends Migration
{
    public function safeUp()
    {

    }

    public function safeDown()
    {
        echo "m171009_192324_add_new_field_to_profile cannot be reverted.\n";

        return false;
    }

    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->addColumn('{{%profile}}', 'field', Schema::TYPE_STRING);
    }

    public function down()
    {
        $this->dropColumn('{{%profile}}', 'field');
    }
    
}
