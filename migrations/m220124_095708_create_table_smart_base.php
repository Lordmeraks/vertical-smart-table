<?php

use yii\db\Migration;

/**
 * Class m220124_095708_create_table_smart_base
 */
class m220124_095708_create_table_smart_base extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('crm.smart_base', [
            'id' => $this->primaryKey(),
            'field' => $this->string(),
            'value' => $this->string(),
            'client_number' => $this->string(),
            'dialogue_id' => $this->integer(),
        ],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('crm.smart_base');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220124_095708_create_table_smart_base cannot be reverted.\n";

        return false;
    }
    */
}
