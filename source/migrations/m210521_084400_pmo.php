<?php

use yii\db\Migration;

/**
 * Class m210521_084400_pmo
 */
class m210521_084400_pmo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("pmo_projects", [
            'id' => $this->primaryKey(),
            'time_created' => $this->timestamp(),
            'id_author' => $this->integer(),
            'name' => $this->string(250),
            'selected_row' => $this->integer(),
            'can_add' => $this->boolean(),
            'can_write' => $this->boolean(),
            'can_write_on_parent' => $this->boolean(),
            'zoom' => $this->string(10),
        ]);
        $this->createTable("pmo_tasks", [
            'id' => $this->primaryKey(),
            'id_author' => $this->integer(),
            'time_created' => $this->timestamp(),
            'task_order' => $this->integer(),
            'name' => $this->string(250),
            'progress' => $this->integer(),
            'progress_by_worklog' => $this->boolean(),
            'relevance' => $this->integer(),
            'type' => $this->string(100),
            'type_id' => $this->integer(),
            'description' => $this->text(),
            'code' => $this->integer(),
            'level' => $this->integer(),
            'status' => $this->string(100),
            'depends' => $this->string(50),
            'start' => $this->timestamp(),
            'end' => $this->timestamp(),
            'startPlan' => $this->timestamp(),
            'endPlan' => $this->timestamp(),
            'duration' => $this->integer(),
            'start_is_milestone' => $this->boolean(),
            'end_is_milestone' => $this->boolean(),
            'collapsed' => $this->boolean(),
            'can_write' => $this->boolean(),
            'can_add' => $this->boolean(),
            'can_delete' => $this->boolean(),
            'can_add_issue' => $this->boolean(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210521_084400_pmo cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210521_084400_pmo cannot be reverted.\n";

        return false;
    }
    */
}
