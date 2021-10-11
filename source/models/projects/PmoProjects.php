<?php

namespace app\models\projects;

use dektrium\user\models\Profile;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "pmo_projects".
 *
 * @property int $id
 * @property string|null $time_created
 * @property int|null $id_author
 * @property string|null $name
 * @property int|null $selected_row
 * @property int|null $can_add
 * @property int|null $can_write
 * @property int|null $can_write_on_parent
 * @property string|null $zoom
 * @property int|null $is_strategic
 * @property int|null $deleted
 *
 * @property array $tasks
 */
class PmoProjects extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pmo_projects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['time_created'], 'safe'],
            [['id_author', 'selected_row', 'can_add', 'can_write', 'can_write_on_parent', 'is_strategic', 'deleted'], 'integer'],
            [['name'], 'string', 'max' => 250],
            [['name',], 'required'],
            [['zoom'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'time_created' => 'Time Created',
            'id_author' => 'Id Author',
            'name' => 'Название',
            'selected_row' => 'Selected Row',
            'can_add' => 'Can Add',
            'can_write' => 'Can Write',
            'can_write_on_parent' => 'Can Write On Parent',
            'zoom' => 'Zoom',
            'id_direction' => 'Направление дирекции',
            'is_strategic' => 'Стратегический проект'
        ];
    }


    public function getTasks()
    {
        return $this->hasMany(PmoTasks::class, ['id_project' => 'id'])->orderBy('task_order');
    }

    public function getTasksSuccessGood()//Задачи завершенные овремя
    {
        return $this->hasMany(PmoTasks::class, ['id_project' => 'id'])->where(['id_status' => 2])->andWhere("end<=endPlan")->orderBy('task_order');
    }

    public function getTasksSuccess()//Завершенные задачи
    {
        return $this->hasMany(PmoTasks::class, ['id_project' => 'id'])->where(['id_status' => 2])->orderBy('task_order');
    }

    public function getTasksActive()//Активные задачи
    {
        return $this->hasMany(PmoTasks::class, ['id_project' => 'id'])->where(['id_status' => 1])->andWhere('task_order <> 0')->orderBy('task_order');
    }

    public function getTasksSuccessFail()//Завершенные, но просроченные задачи
    {
        return $this->hasMany(PmoTasks::class, ['id_project' => 'id'])->where(['id_status' => 2])->andWhere("end>endPlan")->orderBy('task_order');
    }

    public function getTasksFail()//Просроченные задачи
    {
        return $this->hasMany(PmoTasks::class, ['id_project' => 'id'])->where("end>endPlan")->orderBy('task_order');
    }

    public function getResources()
    {
        return $this->hasMany(PmoProjectResources::class, ['id_project' => 'id']);
    }

    public function getRoles()
    {
        return PmoResourcesRole::find()->all();
    }

    public function getAuthor()
    {
        $profile = PmoProfile::getProfile($this->id_author);
        return empty($profile->name ?? "") ? ($profile->user->username ?? "") : $profile->name;
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->id_author = Yii::$app->user->identity->id;
            $this->time_created = date("Y-m-d H:i:s");
            $this->can_add = true;
            $this->can_write = true;
            $this->can_write_on_parent = true;
        }
        return parent::beforeSave($insert);
    }

    public function updateJson(\stdClass $source, $basePlane = false)
    {

        $this->can_add = (int)$source->canAdd;
        $this->selected_row = (int)($source->selectedRow ?? 0);
        $this->can_write = (int)$source->canWrite;
        $this->can_write_on_parent = (int)$source->canWriteOnParent;
        $this->zoom = $source->zoom;
        if (is_array($source->resources)) {
            foreach ($source->resources as $res) {
                $model = PmoProjectResources::find()->where(['id_project' => $this->id, 'id_resource' => $res->id])->one();
                if (!isset($model->id))
                    $model = new PmoProjectResources();
                $model->id_resource = $res->id;
                $model->id_project = $this->id;
                $model->save();
            }
        }
        $this->save();
        if (isset($source->deletedTaskIds)) {
            PmoTasks::deleteAll(['id' => $source->deletedTaskIds]);
        }
        foreach ($source->tasks as $index => $task) {
            $taskModel = PmoTasks::find()->where(['id' => $task->id])->one();
            if (!isset($taskModel->id))
                $taskModel = new PmoTasks();
            $taskModel->id_project = $this->id;
            $taskModel->name = $task->name;
            $taskModel->progress = $task->progress;
            $taskModel->progress_by_worklog = (int)$task->progressByWorklog;
            $taskModel->relevance = $task->relevance ?? 0;
            $taskModel->type = $task->type ?? "";
            $taskModel->type_id = $task->typeId ?? 0;
            $taskModel->description = $task->description;
            $taskModel->code = $task->code ?? 0;
            $taskModel->level = $task->level;
            $taskModel->id_status = PmoTaskStatus::getStatusNumber($task->status);
            $taskModel->depends = $task->depends;
            $taskModel->start = $this->correctDate($task->start);
            $taskModel->end = $this->correctDate($task->end);
            if ($basePlane) {
                $taskModel->startPlan = $taskModel->start;
                $taskModel->endPlan = $taskModel->end;
            }
            $taskModel->duration = $task->duration;
            $taskModel->start_is_milestone = (int)$task->startIsMilestone;
            $taskModel->end_is_milestone = (int)$task->endIsMilestone;
            $taskModel->collapsed = (int)($task->collapsed ?? 0);
            $taskModel->can_write = (int)$task->canWrite;
            $taskModel->can_add = (int)$task->canAdd;
            $taskModel->can_delete = (int)$task->canDelete;
            $taskModel->can_add_issue = (int)$task->canAddIssue;
            $taskModel->task_order = $index;
            if (!$taskModel->save()) {
                print_r($taskModel->errors);
                return false;
            }
            if (is_array($task->assigs ?? NULL)) {
                PmoTasksResources::deleteAll(['id_task' => $taskModel->id]);
                foreach ($task->assigs as $as) {
                    $modelTaskRes = new PmoTasksResources();
                    $modelTaskRes->id_task = $taskModel->id;
                    $modelTaskRes->id_resource = $as->resourceId;
                    $modelTaskRes->id_role = $as->roleId;
                    $modelTaskRes->save();
                }
            }
            if (!empty($task->comment ?? 0)) {
                $commentModel = PmoTasksComments::find()->where(['id' => $task->commentId])->one();
                if (!isset($commentModel->id))
                    $commentModel = new PmoTasksComments();
                else
                    if ($commentModel->text !== $task->comment)
                        $commentModel = new PmoTasksComments();
                $commentModel->id_task = $taskModel->id;
                $commentModel->text = $task->comment;
                $commentModel->save();
            }
        }
        return true;
    }

    public function getPms()
    {
        return $this->hasMany(PmoProjectResources::class, ['id_project' => 'id'])->where(['id_role' => 1]);
    }

    public function correctDate($time)
    {
        $time = (int)($time / 1000);
        $n = date("N", $time);
        if ($n > 5) {
            $time = $time + (8 - $n) * 24 * 3600;
        }
        return date("Y-m-d", $time);
    }

    public function getAccessEdit()
    {
        $edit = $this->id_author === (Yii::$app->user->identity->id ?? "null");
        if (!$edit)
            foreach ($this->pms as $pm)
                /**
                 * @var  \app\models\projects\PmoProjectResources $pm
                 */
                if ($pm->res->id_user === (Yii::$app->user->identity->id ?? "null")) {
                    $edit = true;
                    break;
                }
        return $edit;
    }

    public static function findOne($id)
    {
        return parent::findOne(['id' => $id, 'deleted' => 0]);
    }
}
