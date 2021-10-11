<?php

use yii\db\Migration;

/**
 * Class m210525_104041_pmo
 */
class m210525_104041_pmo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\projects\PmoResource::tableName(), 'id_user', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210525_104041_pmo cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210525_104041_pmo cannot be reverted.\n";

        return false;
    }
    */
}
