<?php

use yii\db\Migration;

/**
 * Class m220124_095655_create_table_smart_base_settings
 */
class m220124_095655_create_table_smart_base_settings extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('crm.smart_base_settings', [
            'id' => $this->primaryKey(),
            'created_by' => $this->integer(5)->unsigned(),
            'created_at' => $this->timestamp()->defaultValue(null),
            'updated_at' => $this->timestamp()->defaultValue(null),
            'settings' => $this->text(),
        ],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('crm.smart_base_settings');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220124_095655_create_table_smart_base_settings cannot be reverted.\n";

        return false;
    }
    */
}
