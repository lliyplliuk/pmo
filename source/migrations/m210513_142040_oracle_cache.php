<?php

use yii\db\Migration;

/**
 * Class m210513_142040_oracle_cache
 */
class m210513_142040_oracle_cache extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('oracle_tab_columns', [
            'column_id' => $this->primaryKey(),
            'table_name' => $this->string(50),
            'column_name' => $this->string(50),
            'data_type' => $this->string(100),
            'nullable' => $this->char(1),
            'data_default' => $this->string(100),
            'key' => $this->char(1),
        ]);
        $this->createIndex('pk_oracle_tab_columns', 'oracle_tab_columns', [
            'table_name', 'column_name'
        ]);
        $this->createTable('oracle_tables', [
            'table_name' => $this->string(50),
        ]);
        $this->createIndex('pk_oracle_tables', 'oracle_tables', [
            'table_name'
        ]);
        $this->createTable('oracle_tab_cons', [
            'table_name' => $this->string(50),
            'column_name' => $this->string(50),
            'position' => $this->integer(),
            'r_constraint_name' => $this->string(50),
            'table_ref' => $this->string(50),
            'column_ref' => $this->string(200),
        ]);
        $this->createIndex('pk_oracle_tab_cons', 'oracle_tab_cons', [
            'table_name','column_name'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210513_142040_oracle_cache cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210513_142040_oracle_cache cannot be reverted.\n";

        return false;
    }
    */
}
