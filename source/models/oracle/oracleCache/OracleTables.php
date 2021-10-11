<?php

namespace app\models\oracle\oracleCache;

use Yii;

/**
 * This is the model class for table "oracle_tables".
 *
 * @property string|null $table_name
 */
class OracleTables extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oracle_tables';
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
            [['table_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'table_name' => 'Table Name',
        ];
    }
}
