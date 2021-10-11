<?php

namespace app\controllers;

use Exception;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DirectoryController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function () {
                            return Yii::$app->authManager->checkAccess(Yii::$app->user->identity->id, 'admin');
                        }
                    ],
                ]
            ]
        ];
    }

    public function actionIndex(string $dir)
    {
        $model = $this->getModel($dir);
        $provider = new ActiveDataProvider([
            'query' => $model::find(),
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);
        $tmp=explode('\\',$dir);
        $dirSmall=$tmp[count($tmp)-1];
        return $this->render('directory', compact('model', 'provider', 'dir', 'dirSmall'));
    }

    public function actionAdd(string $dir)
    {
        $model = $this->getModel($dir);
        $model->load(Yii::$app->request->post());
        if ($model->save())
            $this->redirect(["/directory", "dir" => $dir]);
        else
            print_r($model->errors);
    }

    public function actionEdit(string $dir)
    {
        $tmp=explode('\\',$dir);
        $dirSmall=$tmp[count($tmp)-1];
        $model = $this->getModel($dir);
        $values=Yii::$app->request->post($dirSmall);
        $model=$model::find()->where(['id'=>$values["id"]])->one();
        if(!isset($model->id))
            throw new NotFoundHttpException();
        $model->load(Yii::$app->request->post());
        if ($model->save())
            $this->redirect(["/directory", "dir" => $dir]);
        else
            print_r($model->errors);
    }

    private function getModel(string $dir)
    {
        $nameModel = "\\app\\models\\$dir";
        if (class_exists($nameModel)) {
            return new $nameModel;
        } else {
            throw new NotFoundHttpException();
        }
    }
}
