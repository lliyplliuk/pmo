<?php

use yii\db\Migration;

/**
 * Class m210528_084218_pmo
 */
class m210528_084218_pmo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('tasks_status_end_id_proj',\app\models\projects\PmoTasks::tableName(),[
            'id_status','end','endPlan','id_project','task_order'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210528_084218_pmo cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210528_084218_pmo cannot be reverted.\n";

        return false;
    }
    */
}
