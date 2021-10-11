<?php
/**
 * @var $this yii\web\View
 * @var $provider \yii\data\ActiveDataProvider
 * @var $model \app\models\projects\PmoProjects
 * @var $directionArray array
 * @var $resourcesArray array
 * @var $add boolean
 * @var $searchModel \app\models\projects\search\PmoProjectsSearch
 */

use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;

$this->title = "Проекты дирекции автоматизации и цифровизации угольного дивизиона";
$this->params['breadcrumbs'][] = $this->title;

Modal::begin([
    'title' => '<h2 id="modalTitle">Добавить проект</h2>',
    'id' => 'modal'
]);
$form = ActiveForm::begin([
    'id' => 'modalForm',
    'method' => 'post',
    'action' => ["/pmo/add-project"]
]);
?>

<?= $form->field($model, "name")->textInput(); ?>
<?= $form->field($model, 'is_strategic')->checkbox() ?>
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'login-button']); ?>
<?= Html::resetButton('Отменить', ['class' => 'btn btn-danger', 'name' => 'login-button']); ?>
<?php
$form::end();
Modal::end();
?>
<h1>Проекты дирекции</h1>
<?php if ($add): ?>
    <div class="text-right pb-3 pt-3">
        <button class="btn btn-success" id="addBtn" onclick="$('#modal').modal('show');return false;">
            <i class="fas fa-plus-circle"></i>
            Добавить
        </button>
    </div>
<?php endif; ?>

<?= GridView::widget([
    'dataProvider' => $provider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn'],
        [
            'class' => '\app\extensions\grid\ExpandRowColumnAdd',
            'label' => 'Сводка',
            'width' => '50px',
            'value' => function () {
                return GridView::ROW_COLLAPSED;
            },
            'detail' => function ($model) {
                return Yii::$app->controller->renderPartial('detailProject', ['model' => $model]);
            },
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'expandOneOnly' => true
        ],
        ['attribute' => 'name',
            'value' => function ($model) {
                return Html::a($model->name, ["/pmo/gantt", "project" => $model->id]);
            },
            'format' => 'raw'
        ],
        [
            'label' => 'РП',
            'attribute' => 'pm',
            'filter' => $resourcesArray,
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['prompt' => ''],
                'pluginOptions' => ['allowClear' => true],
            ],
            'value' => function ($model) {
                $ret = "";
                foreach ($model->pms as $pm)
                    /**
                     * @var  \app\models\projects\PmoProjectResources $pm
                     */
                    $ret .= "<p>$pm->name</p>";
                if (empty($ret))
                    $ret = $model->author ?? "";
                return $ret;
            },
            'format' => 'raw'
        ],
        ['attribute' => 'is_strategic',
            'value' => function ($model) {
                return ($model->is_strategic === 1) ? '<i class="fa fa-check text-success" aria-hidden="true"></i>' : '<i class="fa fa-minus text-error" aria-hidden="true"></i>';
            },
            'format' => 'raw',
            'filter' => [0 => "Нет", 1 => "Да"],
            'filterType' => GridView::FILTER_SELECT2,
            'filterWidgetOptions' => [
                'options' => ['prompt' => ''],
                'pluginOptions' => ['allowClear' => true],
            ],
        ],
        [
            'value' => function ($model) {
                return $model->accessEdit ? Html::a('<i class="fas fa-pencil-alt text-success"></i>', ["/pmo/edit-project", 'project' => $model->id], ['title' => 'Изменить']) : "";
            },
            'format' => 'raw'
        ],
    ]
]); ?>

