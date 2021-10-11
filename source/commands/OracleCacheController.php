<?php


namespace app\commands;


use app\models\oracleCache\OracleTabColumns;
use app\models\oracleCache\OracleTabCons;
use app\models\oracleCache\OracleTables;
use Yii;
use yii\base\BaseObject;
use yii\console\Controller;

class OracleCacheController extends Controller
{
    public function actionGet()
    {
//        $sql = <<<EOD
//		SELECT a.column_name, a.data_type ||
//    case
//        when data_precision is not null
//            then '(' || a.data_precision ||
//                    case when a.data_scale > 0 then ',' ||
//a.data_scale else '' end
//                || ')'
//        when data_type = 'DATE' then ''
//        else '(' || to_char(a.data_length) || ')'
//    end as data_type,
//    a.nullable, a.data_default,
//    (   SELECT D.constraint_type
//        FROM user_CONS_COLUMNS C
//        inner join user_constraints D On D.constraint_name = C.constraint_name
//        Where C.table_name = A.TABLE_NAME
//           and C.column_name = A.column_name
//           and D.constraint_type = 'P') as Key,
//		A.TABLE_NAME
//FROM user_TAB_COLUMNS A
//ORDER by a.column_id
//EOD;
//        $command = Yii::$app->get('dbChuk')->createCommand($sql);
//        if (($columns = $command->queryAll()) === array()) {
//            return false;
//        }
//        foreach ($columns as $column) {
//            $tableName=$column['TABLE_NAME'];
//            $tableModel = OracleTables::find()->where(['table_name' => $tableName])->one();
//            if (!isset($tableModel->table_name)) {
//                $tableModel = new OracleTables();
//                $tableModel->table_name = $tableName;
//                $tableModel->save();
//            }
//            $columnModel = OracleTabColumns::find()->where(['table_name' => $tableName, 'column_name' => $column['COLUMN_NAME']])->one();
//            if (!isset($columnModel->column_id))
//                $columnModel = new OracleTabColumns();
//            $columnModel->table_name = $tableName;
//            $columnModel->column_name = $column['COLUMN_NAME'];
//            $columnModel->data_type = $column['DATA_TYPE'];
//            $columnModel->nullable = $column['NULLABLE'];
//            $columnModel->data_default = $column['DATA_DEFAULT'];
//            $columnModel->key = $column['KEY'];
//            $columnModel->save();
//        }
        $tables = OracleTables::find()->all();
        foreach ($tables as $table) {
            $sql = <<<EOD
		SELECT
    /*+ PUSH_PRED(C) PUSH_PRED(D) PUSH_PRED(E) */
    C.COLUMN_NAME,
    C.POSITION,
    D.R_CONSTRAINT_NAME,
    E.TABLE_NAME AS TABLE_REF,
    F.COLUMN_NAME AS COLUMN_REF,
    C.TABLE_NAME,
	A.DATA_PRECISION,
    A.DATA_SCALE,
    (
      CASE A.CHAR_USED WHEN 'C' THEN A.CHAR_LENGTH
        ELSE A.DATA_LENGTH
      END
    ) AS DATA_LENGTH
FROM ALL_CONS_COLUMNS C
    INNER JOIN ALL_CONSTRAINTS D ON D.OWNER = C.OWNER AND D.CONSTRAINT_NAME = C.CONSTRAINT_NAME
    LEFT JOIN ALL_CONSTRAINTS E ON E.OWNER = D.R_OWNER AND E.CONSTRAINT_NAME = D.R_CONSTRAINT_NAME
    LEFT JOIN ALL_CONS_COLUMNS F ON F.OWNER = E.OWNER AND F.CONSTRAINT_NAME = E.CONSTRAINT_NAME AND F.POSITION = C.POSITION
	INNER join ALL_TAB_COLUMNS A on A.OWNER=C.OWNER and A.TABLE_NAME=C.TABLE_NAME
WHERE
    C.OWNER = 'DISPATCHER'
    AND C.TABLE_NAME = '{$table->table_name}'
ORDER BY D.CONSTRAINT_NAME, C.POSITION
EOD;
            $command = Yii::$app->get('dbChuk')->createCommand($sql);
            $links = $command->queryAll();
            if (!empty($links))
                foreach ($links as $link) {
                    $consModel = OracleTabCons::find()->where(['table_name' => $table->table_name, 'column_name' => $link['COLUMN_NAME']])->one();
                    if (!isset($consModel->table_name))
                        $consModel = new OracleTabCons();
                    $consModel->table_name = $table->table_name;
                    $consModel->column_name = $link['COLUMN_NAME'];
                    $consModel->position = $link['POSITION'];
                    $consModel->r_constraint_name = $link['R_CONSTRAINT_NAME'];
                    $consModel->table_ref = $link['TABLE_REF'];
                    $consModel->column_ref = $link['COLUMN_REF'];
                    $consModel->data_precision = $link['DATA_PRECISION'];
                    $consModel->data_scale = $link['DATA_SCALE'];
                    $consModel->data_length = $link['DATA_LENGTH'];
                    if (!$consModel->save())
                        print_r($consModel->errors);
                }
        }


    }
}