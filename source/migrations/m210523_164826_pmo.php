<?php

use yii\db\Migration;

/**
 * Class m210523_164826_pmo
 */
class m210523_164826_pmo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('pmo_task_status', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)
        ]);
        $this->insert('pmo_task_status',['name'=>'STATUS_ACTIVE']);
        $this->insert('pmo_task_status',['name'=>'STATUS_DONE']);
        $this->insert('pmo_task_status',['name'=>'STATUS_FAILED']);
        $this->insert('pmo_task_status',['name'=>'STATUS_SUSPENDED']);
        $this->insert('pmo_task_status',['name'=>'STATUS_WAITING']);
        $this->insert('pmo_task_status',['name'=>'STATUS_UNDEFINED']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210523_164826_pmo cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210523_164826_pmo cannot be reverted.\n";

        return false;
    }
    */
}
