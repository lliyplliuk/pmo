<?php

namespace app\models\projects;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "pmo_tasks".
 *
 * @property int $id
 * @property int|null $id_author
 * @property string|null $time_created
 * @property int|null $task_order
 * @property string|null $name
 * @property int|null $progress
 * @property int|null $progress_by_worklog
 * @property int|null $relevance
 * @property string|null $type
 * @property int|null $type_id
 * @property string|null $description
 * @property int|null $code
 * @property int|null $level
 * @property string|null $depends
 * @property string|null $start
 * @property string|null $end
 * @property string|null $startPlan
 * @property string|null $endPlan
 * @property int|null $duration
 * @property int|null $start_is_milestone
 * @property int|null $end_is_milestone
 * @property int|null $collapsed
 * @property int|null $can_write
 * @property int|null $can_add
 * @property int|null $can_delete
 * @property int|null $can_add_issue
 * @property int|null $id_project
 * @property int|null $id_status
 * @property string|null $status
 *
 * @property array $comments
 * @property PmoTasksComments $lastComment
 * @property bool $hasEdit
 */
class PmoTasks extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pmo_tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_author', 'task_order', 'progress', 'progress_by_worklog', 'relevance', 'type_id', 'code', 'level', 'duration', 'start_is_milestone', 'end_is_milestone', 'collapsed', 'can_write', 'can_add', 'can_delete', 'can_add_issue', 'id_project', 'id_status'], 'integer'],
            [['time_created', 'start', 'end', 'startPlan', 'endPlan'], 'safe'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 250],
            [['type'], 'string', 'max' => 100],
            [['depends'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_author' => 'Id Author',
            'time_created' => 'Time Created',
            'task_order' => 'Task Order',
            'name' => 'Name',
            'progress' => 'Progress',
            'progress_by_worklog' => 'Progress By Worklog',
            'relevance' => 'Relevance',
            'type' => 'Type',
            'type_id' => 'Type ID',
            'description' => 'Description',
            'code' => 'Code',
            'level' => 'Level',
            'status' => 'Status',
            'depends' => 'Depends',
            'start' => 'Start',
            'end' => 'End',
            'startPlan' => 'Start Plan',
            'endPlan' => 'End Plan',
            'duration' => 'Duration',
            'start_is_milestone' => 'Start Is Milestone',
            'end_is_milestone' => 'End Is Milestone',
            'collapsed' => 'Collapsed',
            'can_write' => 'Can Write',
            'can_add' => 'Can Add',
            'can_delete' => 'Can Delete',
            'can_add_issue' => 'Can Add Issue',
        ];
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->id_author = Yii::$app->user->identity->id;
            $this->startPlan = $this->start;
            $this->endPlan = $this->end;
            $this->time_created = date("Y-m-d H:i:s");
        }
        return parent::beforeSave($insert);
    }

    public function getStatus()
    {
        return $this->hasOne(PmoTaskStatus::class, ['id' => 'id_status'])->one()->name;
    }

    public function getResource()
    {
        return $this->hasMany(PmoTasksResources::class, ['id_task' => 'id']);
    }

    public function getComments()
    {
        return $this->hasMany(PmoTasksComments::class, ['id_task' => 'id'])->orderBy('time_created DESC');
    }

    public function getLastComment()
    {
        return $this->hasOne(PmoTasksComments::class, ['id_task' => 'id'])->orderBy('time_created DESC');
    }

    public function getHasEdit()
    {
        $arr = [];
        foreach ($this->resource as $res)
            if (($res->res->id_user ?? "null") === Yii::$app->user->identity->id)
                return true;
        return ($this->id_author === Yii::$app->user->identity->id);
    }
}
