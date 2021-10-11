<?php

use yii\db\Migration;

/**
 * Class m210518_143555_systems
 */
class m210518_143555_systems extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('systems', [
            'id' => $this->primaryKey(),
            'name' => $this->string(50),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210518_143555_systems cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210518_143555_systems cannot be reverted.\n";

        return false;
    }
    */
}
