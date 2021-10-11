<?php
/**
 * @var $this yii\web\View
 * @var $project \app\models\projects\PmoProjects
 * @var $users array
 * @var $roles array
 * @var $directionArray array
 * @var $companies array
 * @var $model \app\models\projects\PmoProjectResources
 * @var $modelRes \app\models\projects\PmoResource
 * @var $companyModel \app\models\projects\PmoCompany
 */

use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;

$this->title = "Редактирование проекта $project->name.";
$this->params['breadcrumbs'][] = [
    'label' => 'Проекты дирекции',
    'url' => ['/pmo'],
];
$this->params['breadcrumbs'][] = [
    'label' => "Проект $project->name. Диаграмма гантта",
    'url' => ["/pmo/gantt", 'project' => $project->id],
];
$this->params['breadcrumbs'][] = $this->title;
?>
    <h1><?= $this->title ?></h1>
    <div class="text-right">
        <?= Html::a('<i class="fa fa-trash" aria-hidden="true" data-target="#confirm-delete"></i> Удалить', ['/pmo/delete-project', 'project' => $project->id], ['class' => 'btn btn-danger']) ?>
    </div>
<?php
$form = ActiveForm::begin([
    'method' => 'post',
    'action' => ["/pmo/save-project", 'project' => $project->id]
]);
?>

<?= $form->field($project, "name")->textInput(); ?>
<?= $form->field($project, 'is_strategic')->checkbox() ?>
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'save']); ?>
<?= Html::resetButton('Отменить', ['class' => 'btn btn-danger']); ?>
<?php
$form::end();
$form = ActiveForm::begin([
    'method' => 'post',
    'action' => ["/pmo/add-resources-to-project", 'project' => $project->id]
]);
?>
    <br/>
    <br/>
    <h2>Ресурсы проекта</h2>
    <table class="table" id="res">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Имя</th>
            <th scope="col">Роль</th>
            <th scope="col">Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($project->resources as $i => $res): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= $res->name ?> (<?= $res->position ?> - <?= $res->company ?>)</td>
                <td><?= $res->role ?></td>
                <td><?= HTML::a('<i class="fa fa-trash text-danger" aria-hidden="true"></i>', ["/pmo/delete-resource-from-project", 'resource' => $res->id, 'project' => $project->id], ['title' => 'Удалить']) ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td></td>
            <td><?= $form->field($model, "id_resource")->widget(Select2::class, [
                    'data' => $users,
                    'options' => ['placeholder' => 'Выберите ресурс...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false) ?></td>
            <td><?= $form->field($model, "id_role")->widget(Select2::class, [
                    'data' => $roles,
                    'options' => ['placeholder' => 'Выберите роль...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false) ?>
            </td>
            <td><?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']); ?></td>
        </tr>
        </tbody>
    </table>
<?php
$form::end();
echo Html::button("<i class='fas fa-plus-circle text-success'></i>Добавить ресурс", ['class' => 'btn btn-secondary', "data-toggle" => "modal", "data-target" => "#modalAddRes"]);
Modal::begin([
    'title' => '<h2>Добавить ресурс</h2>',
    'id' => 'modalAddRes'
]);
$form = ActiveForm::begin([
    'method' => 'post',
    'action' => ["/pmo/add-resource-dir", 'project' => $project->id]
]);
?>

<?= $form->field($modelRes, "name")->textInput(); ?>
<?= $form->field($modelRes, "email")->textInput(); ?>
<?= $form->field($modelRes, "position")->textInput(); ?>
<?= $form->field($modelRes, "id_company")->widget(Select2::class, [
    'data' => $companies,
    'options' => ['placeholder' => 'Выберите предприятие...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label(false) ?>
<?= Html::button("<i class='fas fa-plus-circle text-success'></i>Добавить предприятие", ['class' => 'btn btn-secondary', "data-toggle" => "modal", "data-target" => "#modalAddCompany"]); ?>
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']); ?>
<?= Html::resetButton('Отменить', ['class' => 'btn btn-danger']); ?>
<?php
$form::end();
Modal::end();

Modal::begin([
    'title' => '<h2>Добавить предприятие</h2>',
    'id' => 'modalAddCompany'
]);
$form = ActiveForm::begin([
    'method' => 'post',
    'action' => ["/pmo/add-company"]
]);
?>
<?= $form->field($companyModel, "name")->textInput(); ?>
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']); ?>
<?php
$form::end();
Modal::end();
