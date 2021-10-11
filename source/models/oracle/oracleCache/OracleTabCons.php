<?php

namespace app\models\oracle\oracleCache;

use Yii;

/**
 * This is the model class for table "oracle_tab_cons".
 *
 * @property string|null $table_name
 * @property string|null $column_name
 * @property int|null $position
 * @property string|null $r_constraint_name
 * @property string|null $table_ref
 * @property string|null $column_ref
 * @property int|null $data_precision
 * @property int|null $data_scale
 * @property int|null $data_length
 */
class OracleTabCons extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'oracle_tab_cons';
    }

    public static function primaryKey()
    {
        return ['table_name', 'column_name'];
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
            [['position', 'data_length', 'data_scale', 'data_precision'], 'integer'],
            [['table_name', 'column_name', 'r_constraint_name', 'table_ref'], 'string', 'max' => 50],
            [['column_ref'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'table_name' => 'Table Name',
            'column_name' => 'Column Name',
            'position' => 'Position',
            'r_constraint_name' => 'R Constraint Name',
            'table_ref' => 'Table Ref',
            'column_ref' => 'Column Ref',
        ];
    }
}
