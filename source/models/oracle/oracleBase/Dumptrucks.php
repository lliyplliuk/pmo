<?php

namespace app\models\oracle\oracleBase;

use Yii;

/**
 * This is the model class for table "DUMPTRUCKS".
 *
 * @property string $VEHID
 * @property string|null $VEHNAME
 * @property string|null $MODEL
 * @property float|null $CAPACITY
 * @property int $ISCONTROLLED
 * @property int|null $CONTROLID
 * @property int $WEIGHTSENSORENABLED
 * @property int $FUELSENSORENABLED
 * @property int $BODYVOLUME
 * @property int $ISSTANDARD
 * @property string|null $CONTROLVEHID
 * @property int|null $COLUMNNUM
 * @property int|null $VEHCOLUMNNUM
 * @property int|null $SPEEDTYPE
 * @property string|null $INNUM
 * @property string|null $SITE
 * @property float|null $LIMZAPR
 * @property float|null $MINFUEL
 * @property int|null $ID
 * @property float|null $FUEL1UP
 * @property string|null $GOSNUMBER
 * @property string|null $EXPORT_CODE
 * @property float|null $CAPACITY_MODEL
 * @property int $DEDUCTED
 * @property int|null $PARUSID
 * @property string|null $REPORT_TYPE Optimization module from tug
 * @property int|null $BASE_PARK
 *
 * @property DUMPTRUCKRFIDINFOS $dUMPTRUCKRFIDINFOS
 * @property PARKINGEVENTS[] $pARKINGEVENTSs
 * @property RFIDEVENTS[] $rFIDEVENTSs
 * @property RFIDS[] $rFIDSs
 * @property SHIFTBORDERS[] $sHIFTBORDERSs
 * @property SHIFTTASKS[] $sHIFTTASKSs
 * @property SIMPLETRANSITIONS[] $sIMPLETRANSITIONSs
 * @property TRANSITIONS[] $tRANSITIONSs
 */
class Dumptrucks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'DUMPTRUCKS';
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
            [['VEHID'], 'required'],
            [['CAPACITY', 'LIMZAPR', 'MINFUEL', 'FUEL1UP', 'CAPACITY_MODEL'], 'number'],
            [['ISCONTROLLED', 'CONTROLID', 'WEIGHTSENSORENABLED', 'FUELSENSORENABLED', 'BODYVOLUME', 'ISSTANDARD', 'COLUMNNUM', 'VEHCOLUMNNUM', 'SPEEDTYPE', 'ID', 'DEDUCTED', 'PARUSID', 'BASE_PARK'], 'integer'],
            [['VEHID', 'SITE'], 'string', 'max' => 12],
            [['VEHNAME', 'MODEL', 'CONTROLVEHID', 'GOSNUMBER'], 'string', 'max' => 30],
            [['INNUM'], 'string', 'max' => 25],
            [['EXPORT_CODE'], 'string', 'max' => 10],
            [['REPORT_TYPE'], 'string', 'max' => 15],
            [['ID'], 'unique'],
            [['VEHID'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'VEHID' => 'Vehid',
            'VEHNAME' => 'Vehname',
            'MODEL' => 'Model',
            'CAPACITY' => 'Capacity',
            'ISCONTROLLED' => 'Iscontrolled',
            'CONTROLID' => 'Controlid',
            'WEIGHTSENSORENABLED' => 'Weightsensorenabled',
            'FUELSENSORENABLED' => 'Fuelsensorenabled',
            'BODYVOLUME' => 'Bodyvolume',
            'ISSTANDARD' => 'Isstandard',
            'CONTROLVEHID' => 'Controlvehid',
            'COLUMNNUM' => 'Columnnum',
            'VEHCOLUMNNUM' => 'Vehcolumnnum',
            'SPEEDTYPE' => 'Speedtype',
            'INNUM' => 'Innum',
            'SITE' => 'Site',
            'LIMZAPR' => 'Limzapr',
            'MINFUEL' => 'Minfuel',
            'ID' => 'ID',
            'FUEL1UP' => 'Fuel1 Up',
            'GOSNUMBER' => 'Gosnumber',
            'EXPORT_CODE' => 'Export Code',
            'CAPACITY_MODEL' => 'Capacity Model',
            'DEDUCTED' => 'Deducted',
            'PARUSID' => 'Parusid',
            'REPORT_TYPE' => 'Report Type',
            'BASE_PARK' => 'Base Park',
        ];
    }

    /**
     * Gets query for [[DUMPTRUCKRFIDINFOS]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDUMPTRUCKRFIDINFOS()
    {
        return $this->hasOne(DUMPTRUCKRFIDINFOS::className(), ['DUMPTRUCK_VEHID' => 'VEHID']);
    }

    /**
     * Gets query for [[PARKINGEVENTSs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPARKINGEVENTSs()
    {
        return $this->hasMany(PARKINGEVENTS::className(), ['DUMPTRUCK_VEHID' => 'VEHID']);
    }

    /**
     * Gets query for [[RFIDEVENTSs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRFIDEVENTSs()
    {
        return $this->hasMany(RFIDEVENTS::className(), ['DUMPTRUCK_VEHID' => 'VEHID']);
    }

    /**
     * Gets query for [[RFIDSs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRFIDSs()
    {
        return $this->hasMany(RFIDS::className(), ['DUMPTRUCK_VEHID' => 'VEHID']);
    }

    /**
     * Gets query for [[SHIFTBORDERSs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSHIFTBORDERSs()
    {
        return $this->hasMany(SHIFTBORDERS::className(), ['VEHID' => 'VEHID']);
    }

    /**
     * Gets query for [[SHIFTTASKSs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSHIFTTASKSs()
    {
        return $this->hasMany(SHIFTTASKS::className(), ['VEHCODE' => 'ID']);
    }

    /**
     * Gets query for [[SIMPLETRANSITIONSs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSIMPLETRANSITIONSs()
    {
        return $this->hasMany(SIMPLETRANSITIONS::className(), ['VEHCODE' => 'ID']);
    }

    /**
     * Gets query for [[TRANSITIONSs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTRANSITIONSs()
    {
        return $this->hasMany(TRANSITIONS::className(), ['VEHCODE' => 'ID']);
    }
}
