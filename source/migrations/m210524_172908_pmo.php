<?php

use yii\db\Migration;

/**
 * Class m210524_172908_pmo
 */
class m210524_172908_pmo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('pmo_tasks_comments', [
            'id' => $this->primaryKey(),
            'id_task' => $this->integer(),
            'id_author' => $this->integer(),
            'time_created' => $this->timestamp(),
            'text' => $this->text()
        ]);
        $this->createIndex('pk_task_time','pmo_tasks_comments',['id_task','time_created']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210524_172908_pmo cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210524_172908_pmo cannot be reverted.\n";

        return false;
    }
    */
}
