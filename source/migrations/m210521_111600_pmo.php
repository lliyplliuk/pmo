<?php

use yii\db\Migration;

/**
 * Class m210521_111600_pmo
 */
class m210521_111600_pmo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(\app\models\projects\PmoProjects::tableName(),
            'is_strategic', $this->boolean()
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210521_111600_pmo cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210521_111600_pmo cannot be reverted.\n";

        return false;
    }
    */
}
