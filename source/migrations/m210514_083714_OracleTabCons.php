<?php

use app\models\oracleCache\OracleTabCons;
use yii\db\Migration;

/**
 * Class m210514_083714_OracleTabCons
 */
class m210514_083714_OracleTabCons extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(OracleTabCons::tableName(),'data_precision',$this->integer());
        $this->addColumn(OracleTabCons::tableName(),'data_scale',$this->integer());
        $this->addColumn(OracleTabCons::tableName(),'data_length',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210514_083714_OracleTabCons cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210514_083714_OracleTabCons cannot be reverted.\n";

        return false;
    }
    */
}
