<?php

use yii\db\Migration;

/**
 * Class m210526_122919_pmo
 */
class m210526_122919_pmo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('pmo_direction');
        $this->dropColumn(\app\models\projects\PmoProjects::tableName(), 'id_direction');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210526_122919_pmo cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210526_122919_pmo cannot be reverted.\n";

        return false;
    }
    */
}
