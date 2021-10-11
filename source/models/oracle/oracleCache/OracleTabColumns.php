<?php

namespace app\models\oracle\oracleCache;

use Yii;

/**
 * This is the model class for table "oracle_tab_columns".
 *
 * @property int $column_id
 * @property string|null $table_name
 * @property string|null $column_name
 * @property string|null $data_type
 * @property string|null $nullable
 * @property string|null $data_default
 * @property string|null $key
 */
class OracleTabColumns extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oracle_tab_columns';
    }

    public static function getDb()
    {
        return Yii::$app->get('db');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['table_name', 'column_name'], 'string', 'max' => 50],
            [['data_type', 'data_default'], 'string', 'max' => 100],
            [['nullable', 'key'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'column_id' => 'Column ID',
            'table_name' => 'Table Name',
            'column_name' => 'Column Name',
            'data_type' => 'Data Type',
            'nullable' => 'Nullable',
            'data_default' => 'Data Default',
            'key' => 'Key',
        ];
    }
}
