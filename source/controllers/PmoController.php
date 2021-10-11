<?php

namespace app\controllers;

use app\models\projects\PmoCompany;
use app\models\projects\PmoProjectResources;
use app\models\projects\PmoProjects;
use app\models\projects\PmoResource;
use app\models\projects\PmoResourcesRole;
use app\models\projects\search\PmoProjectsSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotAcceptableHttpException;
use yii\web\NotFoundHttpException;

class PmoController extends Controller
{
    private array $permissions = [];

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['index', 'gantt', 'save-tasks', 'edit-project', 'save-project', 'add-resources-to-project', 'delete-resource-from-project', 'add-resource-dir', 'add-company', 'delete-project'],
                        'matchCallback' => function () {
                            return true;
                        }
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'actions' => ['add-project'],
                        'matchCallback' => function () {
                            return Yii::$app->authManager->checkAccess(Yii::$app->user->identity->id, 'pmo');
                        }
                    ],
                ]
            ]
        ];
    }

    public function init()
    {
        parent::init();
    }

    public function actionIndex()
    {
        $model = new PmoProjects();
        $searchModel = new PmoProjectsSearch();
        $provider = $searchModel->search(Yii::$app->request->get());
        $resourcesArray = ArrayHelper::map(PmoResource::find()->where(['is_pm' => 1])->orderBy('name')->all(), 'id', 'name');
        $add = Yii::$app->authManager->checkAccess(Yii::$app->user->identity->id, 'pmo');
        return $this->render('index', compact('provider', 'model', 'add', 'searchModel', 'resourcesArray'));
    }

    public function actionAddProject()
    {
        if (!Yii::$app->authManager->checkAccess(Yii::$app->user->identity->id, 'pmo'))
            throw new NotAcceptableHttpException();
        $model = new PmoProjects();
        $res = Yii::$app->request->post('PmoProjects');
        if ($res) {
            $model->load(Yii::$app->request->post());
            if ($model->save())
                \Yii::$app->session->setFlash('success', "Проект добавлен");
            else
                \Yii::$app->session->setFlash('error', "Во время добавления произошла ошибка");
        }
        return $this->redirect(["/pmo"]);
    }


    public function actionGantt(int $project)
    {
        $project = PmoProjects::findOne($project);
        if (!isset($project->id))
            throw new NotFoundHttpException();
        return $this->render('gantt', compact("project"));
    }

    public function actionSaveTasks(int $project, int $basePlane = 0)
    {
        $project = PmoProjects::findOne($project);
        if (!isset($project->id) || !Yii::$app->request->post("json"))
            throw new NotFoundHttpException();
        $source = json_decode(Yii::$app->request->post("json"));
        $project->updateJson($source, $basePlane === 1);
        \Yii::$app->session->setFlash('success', "Задачи сохранены");
    }

    public function actionEditProject(int $project)
    {
        $project = PmoProjects::findOne($project);
        if (!isset($project->id))
            throw new NotFoundHttpException();
        if (!$project->accessEdit)
            throw new NotAcceptableHttpException();
        $users = ArrayHelper::map(PmoResource::find()->orderBy('name')->all(), 'id', 'name');
        $roles = ArrayHelper::map(PmoResourcesRole::find()->orderBy('name')->all(), 'id', 'name');
        $companies = ArrayHelper::map(PmoCompany::find()->orderBy('name')->all(), 'id', 'name');
        $companyModel = new PmoCompany();
        $model = new PmoProjectResources();
        $modelRes = new PmoResource();
        return $this->render('edit', compact('project', 'users', 'roles', 'model', 'modelRes', 'companies', 'companyModel'));
    }

    public function actionSaveProject(int $project)
    {
        $projectModel = PmoProjects::findOne($project);
        if (!isset($projectModel->id))
            throw new NotFoundHttpException();
        $projectModel->load(Yii::$app->request->post());
        if ($projectModel->save())
            \Yii::$app->session->setFlash('success', "Проект сохранен");
        else
            \Yii::$app->session->setFlash('error', "Во время добавления произошла ошибка");
        return $this->redirect(["/pmo/edit-project", 'project' => $project]);
    }

    public function actionAddResourcesToProject(int $project)
    {
        $projectModel = PmoProjects::findOne($project);
        if (!isset($projectModel->id))
            throw new NotFoundHttpException();
        $res = Yii::$app->request->post("PmoProjectResources");
        $model = PmoProjectResources::find()->where(['id_project' => $project, 'id_resource' => $res['id_resource']])->one();
        if (!isset($model->id))
            $model = new PmoProjectResources();
        $model->load(Yii::$app->request->post());
        $model->id_project = $project;
        if ($model->save())
            \Yii::$app->session->setFlash('success', "Ресурс добавлен");
        else
            \Yii::$app->session->setFlash('error', "Во время добавления произошла ошибка");
        return $this->redirect(["/pmo/edit-project", 'project' => $project, '#' => "res"]);
    }

    public function actionDeleteResourceFromProject(int $project, int $resource)
    {
        PmoProjectResources::deleteAll(['id_project' => $project, 'id' => $resource]);
        \Yii::$app->session->setFlash('success', "Ресурс удален");
        return $this->redirect(["/pmo/edit-project", 'project' => $project, '#' => "res"]);
    }

    public function actionDeleteProject(int $project)
    {
        $project = PmoProjects::findOne($project);
        if (!isset($project->id))
            throw new NotFoundHttpException();
        if (!$project->accessEdit)
            throw new NotAcceptableHttpException();
        $project->deleted = 1;
        $project->save();
        \Yii::$app->session->setFlash('success', "Проект удален");
        return $this->redirect(["/pmo"]);
    }

    public function actionAddResourceDir(int $project)
    {
        $res = Yii::$app->request->post('PmoResource');
        if ($res) {
            $new = true;
            if (!empty($res['email'])) {
                $model = PmoResource::find()->where(['email' => mb_strtolower($res['email'])])->one();
                if (isset($model->id))
                    $new = false;
            }
            if ($new)
                $model = new PmoResource();
            $model->load(Yii::$app->request->post());
            if ($model->save())
                \Yii::$app->session->setFlash('success', "Ресур добавлен");
            else
                \Yii::$app->session->setFlash('error', "Во время добавления произошла ошибка");
        }
        return $this->redirect(["/pmo/edit-project", 'project' => $project, '#' => "res"]);
    }

    public function actionAddCompany()
    {
        $model = new PmoCompany();
        $model->load(Yii::$app->request->post());
        if ($model->save())
            \Yii::$app->session->setFlash('success', "Предприятие добавлено");
        else
            \Yii::$app->session->setFlash('error', "Во время добавления произошла ошибка");
        return $this->redirect(Yii::$app->request->referrer ?: ["/pmo"]);
    }
}
