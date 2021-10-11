<?php

use yii\db\Migration;

/**
 * Class m210524_112039_pmo
 */
class m210524_112039_pmo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\projects\PmoProjectResources::tableName(),"id_project",$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210524_112039_pmo cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210524_112039_pmo cannot be reverted.\n";

        return false;
    }
    */
}
