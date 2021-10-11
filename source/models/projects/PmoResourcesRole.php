<?php

namespace app\models\projects;

use Yii;

/**
 * This is the model class for table "pmo_resources_role".
 *
 * @property int $id
 * @property string|null $name
 */
class PmoResourcesRole extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pmo_resources_role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
}
