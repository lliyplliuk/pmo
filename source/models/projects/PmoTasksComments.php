<?php

namespace app\models\projects;

use dektrium\user\models\Profile;
use Yii;

/**
 * This is the model class for table "pmo_tasks_comments".
 *
 * @property int $id
 * @property int|null $id_task
 * @property int|null $id_author
 * @property string|null $time_created
 * @property string|null $text
 * @property string $author
 */
class PmoTasksComments extends \yii\db\ActiveRecord
{
    public static array $cache;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pmo_tasks_comments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_task', 'id_author'], 'integer'],
            [['time_created'], 'safe'],
            [['text'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_task' => 'Id Task',
            'id_author' => 'Id Author',
            'time_created' => 'Time Created',
            'text' => 'Text',
        ];
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->time_created = Yii::$app->formatter->asDatetime('now', "php:Y-m-d h:i:s");// date("Y-m-d h:i:s");
            $this->id_author = Yii::$app->user->identity->id;
        }
        return parent::beforeSave($insert);
    }

    public function getAuthor()
    {
        $profile=PmoProfile::getProfile($this->id_author);
        return (!empty($profile->name)) ? $profile->name : $profile->user->email;
    }
}
