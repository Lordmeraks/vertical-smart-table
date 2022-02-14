<?php

use yii\db\Migration;

/**
 * Class m220124_132233_create_table_smart_base_dialogue
 */
class m220124_132233_create_table_smart_base_dialogue extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('crm.smart_base_dialogue', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(5)->unsigned(),
            'created_at' => $this->timestamp()->defaultValue(null),
        ],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('crm.smart_base_dialogue');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220124_132233_create_table_smart_base_dialogue cannot be reverted.\n";

        return false;
    }
    */
}
