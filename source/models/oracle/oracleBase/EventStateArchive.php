<?php

namespace app\models\oracle\oracleBase;

use Yii;

/**
 * This is the model class for table "EVENTSTATEARCHIVE".
 *
 * @property float|null $MESCOUNTER
 * @property string|null $VEHID
 * @property string|null $TIME
 * @property string|null $GMTTIME
 * @property float|null $X
 * @property float|null $Y
 * @property float|null $WEIGHT
 * @property float|null $FUEL
 * @property float|null $SPEED
 * @property float|null $INCLINATION
 * @property float|null $HEALTHSTATUS
 * @property string|null $TIMESYSTEM
 * @property float|null $EVENTTYPE
 * @property string|null $VEHTYPE
 * @property float|null $VEHCODE
 * @property float|null $FUELFILTERED
 */
class EventStateArchive extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'EVENTSTATEARCHIVE';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('dbChuk');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['MESCOUNTER', 'X', 'Y', 'WEIGHT', 'FUEL', 'SPEED', 'INCLINATION', 'HEALTHSTATUS', 'EVENTTYPE', 'VEHCODE', 'FUELFILTERED'], 'number'],
            [['VEHID', 'TIME', 'GMTTIME', 'TIMESYSTEM', 'VEHTYPE'], 'string'],
            [['MESCOUNTER'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'MESCOUNTER' => 'Mescounter',
            'VEHID' => 'Vehid',
            'TIME' => 'Time',
            'GMTTIME' => 'Gmttime',
            'X' => 'X',
            'Y' => 'Y',
            'WEIGHT' => 'Weight',
            'FUEL' => 'Fuel',
            'SPEED' => 'Speed',
            'INCLINATION' => 'Inclination',
            'HEALTHSTATUS' => 'Healthstatus',
            'TIMESYSTEM' => 'Timesystem',
            'EVENTTYPE' => 'Eventtype',
            'VEHTYPE' => 'Vehtype',
            'VEHCODE' => 'Vehcode',
            'FUELFILTERED' => 'Fuelfiltered',
        ];
    }
}
