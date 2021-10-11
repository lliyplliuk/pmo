<?php

use yii\db\Migration;

/**
 * Class m210705_164739_pmo_directioons
 */
class m210705_164739_pmo_directioons extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('Pmo_directions',['id'=>$this->primaryKey(), 'name'=>$this->string()->notNull()]);
        $this->insert('Pmo_directions',['name'=>'Дирекция по автоматизации и цифровизации']);
        $this->addColumn(\app\models\projects\PmoResource::tableName(),'is_pm',$this->boolean());
        $this->addColumn(\app\models\projects\PmoResource::tableName(),'id_direction',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210705_164739_pmo_directioons cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210705_164739_pmo_directioons cannot be reverted.\n";

        return false;
    }
    */
}
