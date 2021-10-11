<?php

use yii\db\Migration;

/**
 * Class m210524_141009_pmo
 */
class m210524_141009_pmo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\projects\PmoResource::tableName(), 'id_company', $this->integer());
        $this->addColumn(\app\models\projects\PmoResource::tableName(), 'position', $this->string());
        $this->createTable("pmo_company", [
            'id' => $this->primaryKey(),
            'name' => $this->string(200)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210524_141009_pmo cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210524_141009_pmo cannot be reverted.\n";

        return false;
    }
    */
}
