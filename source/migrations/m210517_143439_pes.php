<?php

use yii\db\Migration;

/**
 * Class m210517_143439_pes
 */
class m210517_143439_pes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('pes',[
           'id' =>$this->primaryKey(),
           'name'=>$this->string(100),
           'db_name'=>$this->string(10),
        ]);
        $this->createIndex('pesIndex','pes',['name']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210517_143439_pes cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210517_143439_pes cannot be reverted.\n";

        return false;
    }
    */
}
