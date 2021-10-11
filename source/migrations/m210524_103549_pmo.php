<?php

use yii\db\Migration;

/**
 * Class m210524_103549_pmo
 */
class m210524_103549_pmo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\projects\PmoTasksResources::tableName(),"id",$this->primaryKey());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210524_103549_pmo cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210524_103549_pmo cannot be reverted.\n";

        return false;
    }
    */
}
