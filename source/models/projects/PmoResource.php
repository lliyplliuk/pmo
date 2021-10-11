<?php

namespace app\models\projects;

use app\extensions\dektrium_user\models\User;
use Yii;

/**
 * This is the model class for table "pmo_resource".
 *
 * @property int $id
 * @property int $id_company
 * @property int $id_user
 * @property int $is_pm
 * @property int $id_direction
 * @property string|null $name
 * @property string|null $position
 * @property string|null $email
 */
class PmoResource extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pmo_resource';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'position'], 'string', 'max' => 200],
            [['id_company', 'id_user', 'is_pm', 'id_direction'], 'number'],
            [['name'], 'required'],
            [['email'], 'email']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'ФИО',
            'email' => 'Email',
            'position' => 'Должность',
            'id_company' => 'Предприятие'
        ];
    }

    public function getCompany()
    {
        return $this->hasOne(PmoCompany::class, ['id' => 'id_company']);
    }

    public function getDirections()
    {
        return $this->hasOne(PmoDirections::class, ['id' => 'id_direction']);
    }

    public function beforeSave($insert)
    {
        if (!empty($this->email)) {
            $this->email = mb_strtolower($this->email);
            $user = User::find()->where(['email' => $this->email])->one();
            if (isset($user->id))
                $this->id_user = $user->id;
            else {
                $user = \Yii::createObject([
                    'class' => User::class,
                    'scenario' => 'create',
                ]);
                $tmp=explode('@',$this->email);
                $user->username=$tmp[0];
                $user->password="123123";
                $user->email=$this->email;
                if(!$user->create())
                    print_r($user->errors);
                $this->id_user = $user->id;
            }
        }
        return parent::beforeSave($insert);
    }
}
