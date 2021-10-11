<?php

use yii\db\Migration;

/**
 * Class m210728_085637_deleteProjects
 */
class m210728_085637_deleteProjects extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\projects\PmoProjects::tableName(),'deleted',$this->tinyInteger()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210728_085637_deleteProjects cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210728_085637_deleteProjects cannot be reverted.\n";

        return false;
    }
    */
}
