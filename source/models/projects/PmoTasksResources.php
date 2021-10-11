<?php

namespace app\models\projects;

use Yii;

/**
 * This is the model class for table "pmo_tasks_resources".
 *
 * @property int|null $id_task
 * @property int|null $id
 * @property int|null $id_resource
 * @property int|null $id_role
 */
class PmoTasksResources extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pmo_tasks_resources';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_task', 'id_resource', 'id_role', 'id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_task' => 'Id Task',
            'id_resource' => 'Id Resource',
            'id_role' => 'Id Role',
        ];
    }

    public function getRole()
    {
        return $this->hasOne(PmoResourcesRole::class, ['id' => 'id_role'])->one()->name;
    }

    public function getResource()
    {
        return $this->hasOne(PmoResource::class, ['id' => 'id_resource'])->one()->name;
    }

    public function getRes()
    {
        return $this->hasOne(PmoResource::class, ['id' => 'id_resource']);
    }
}
