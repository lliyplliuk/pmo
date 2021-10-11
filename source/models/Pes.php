<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pes".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $db_name
 * @property string|null $small_name
 */
class Pes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 100],
            [['db_name', 'small_name'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'db_name' => 'Название БД(если есть)',
            'small_name' => 'Короткое название на англ.',
        ];
    }
}
