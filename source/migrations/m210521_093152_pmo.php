<?php

use yii\db\Migration;

/**
 * Class m210521_093152_pmo
 */
class m210521_093152_pmo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('pmo_direction', [
            'id' => $this->primaryKey(),
            'name' => $this->string(200),
            'name_lat' => $this->string(20)
        ]);
        $this->addColumn(\app\models\projects\PmoProjects::tableName(),"id_direction",$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210521_093152_pmo cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210521_093152_pmo cannot be reverted.\n";

        return false;
    }
    */
}
