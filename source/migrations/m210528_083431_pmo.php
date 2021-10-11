<?php

use yii\db\Migration;

/**
 * Class m210528_083431_pmo
 */
class m210528_083431_pmo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('project_id_author',\app\models\projects\PmoProjects::tableName(),['id','id_author']);
        $this->createIndex('project_resource_project_id_resource',\app\models\projects\PmoProjectResources::tableName(),['id_project','id_resource']);
        $this->createIndex('resource_id_user',\app\models\projects\PmoResource::tableName(),['id','id_user']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210528_083431_pmo cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210528_083431_pmo cannot be reverted.\n";

        return false;
    }
    */
}
