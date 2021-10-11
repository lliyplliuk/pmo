<?php

namespace app\models\projects;

use Yii;

/**
 * This is the model class for table "pmo_project_resources".
 *
 * @property int $id
 * @property int|null $id_resource
 * @property int|null $id_project
 * @property int|null $id_role
 */
class PmoProjectResources extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pmo_project_resources';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_resource', 'id_role', 'id_project'], 'integer'],
            [['id_resource', 'id_role'], 'required']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_resource' => 'Ресурс',
            'id_role' => 'Роль',
        ];
    }

    public function getRes()
    {
        return $this->hasOne(PmoResource::class, ['id' => 'id_resource']);
    }

    public function getName()
    {
        return $this->res->name ?? "";
    }

    public function getCompany()
    {
        return $this->res->company->name ?? "";
    }

    public function getPosition()
    {
        return $this->res->position ?? "";
    }

    public function getRole()
    {
        return $this->hasOne(PmoResourcesRole::class, ['id' => 'id_role'])->one()->name ?? "";
    }

    public function getEmail()
    {
        return $this->res->email ?? "";
    }

}
