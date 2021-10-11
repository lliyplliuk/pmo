<?php

use yii\db\Migration;

/**
 * Class m210521_085616_tasks
 */
class m210521_085616_tasks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\projects\PmoTasks::tableName(),"id_project",$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210521_085616_tasks cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210521_085616_tasks cannot be reverted.\n";

        return false;
    }
    */
}
