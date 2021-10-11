<?php

namespace app\models\projects;

use Yii;

/**
 * This is the model class for table "pmo_task_status".
 *
 * @property int $id
 * @property string|null $name
 */
class PmoTaskStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pmo_task_status';
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

    public function getTasks()
    {
        return $this->hasMany(PmoTasks::class, ['id_status' => 'id']);
    }

    public static function getStatusNumber(string $status): int
    {
        $model = self::find()->where(['name' => $status])->one();
        return $model->id ?? 0;
    }
}
