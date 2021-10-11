<?php

use yii\db\Migration;

/**
 * Class m210524_095744_pmo
 */
class m210524_095744_pmo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable("pmo_resources_role", [
            'id' => $this->primaryKey(),
            'name' => $this->string(50)
        ]);
        $this->insert("pmo_resources_role", ["name" => "Руководитель проекта"]);
        $this->insert("pmo_resources_role", ["name" => "Исполнитель"]);
        $this->createTable("pmo_resources", [
            "id" => $this->primaryKey(),
            "id_project" => $this->integer(),
            "name" => $this->string(200),
            "email" => $this->string(200),
        ]);
        $this->createTable("pmo_tasks_resources", [
            "id_task" => $this->integer(),
            "id_resource" => $this->integer(),
            "id_role" => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210524_095744_pmo cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210524_095744_pmo cannot be reverted.\n";

        return false;
    }
    */
}
