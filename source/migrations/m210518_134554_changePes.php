<?php

use yii\db\Migration;

/**
 * Class m210518_134554_changePes
 */
class m210518_134554_changePes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\Pes::tableName(), 'small_name', $this->string(10)->null());
        $this->createIndex("pesSmallName", \app\models\Pes::tableName(), "small_name");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210518_134554_changePes cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210518_134554_changePes cannot be reverted.\n";

        return false;
    }
    */
}
