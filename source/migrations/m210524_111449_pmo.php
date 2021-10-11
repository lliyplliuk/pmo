<?php

use yii\db\Migration;

/**
 * Class m210524_111449_pmo
 */
class m210524_111449_pmo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable("pmo_resources");
        $this->createTable("pmo_resource",[
            'id'=>$this->primaryKey(),
            'name'=>$this->string(200),
            'email'=>$this->string(200),
        ]);
        $this->createTable("pmo_project_resources",[
            'id'=>$this->primaryKey(),
            'id_resource'=>$this->integer(),
            'id_role'=>$this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210524_111449_pmo cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210524_111449_pmo cannot be reverted.\n";

        return false;
    }
    */
}
