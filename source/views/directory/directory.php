<?php
/**
 * @var $this yii\web\View
 * @var $model \app\models\Pes
 * @var $provider \yii\data\ActiveDataProvider
 * @var $dir string
 * @var $dirSmall string
 */

use app\assets\directory\DirectoryAsset;
use kartik\grid\GridView;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;
use yii\helpers\Url;

$this->title = "Справочник $dir";
$this->params['breadcrumbs'][] = $this->title;

$columns = [];
$columns[]['class'] = 'kartik\grid\SerialColumn';
Modal::begin([
    'title' => '<h2 id="modalTitle">Добавить элемент</h2>',
    'id' => 'modal'
]);
$form = ActiveForm::begin([
    'id' => 'modalForm',
    'method' => 'post',
    'action' => ["/directory/add", "dir" => $dir]
]);
foreach ($model->attributes as $name => $val) {
    $columns[]['attribute'] = $name;
    if ($name != "id")
        echo $form->field($model, $name)->textInput();
    else
        echo $form->field($model, $name)->hiddenInput()->label(false);
}
echo Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'login-button']);
echo Html::resetButton('Отменить', ['class' => 'btn btn-danger', 'name' => 'login-button']);
$form::end();
Modal::end();
DirectoryAsset::register($this);
$columns[] = [
    'value' => function ($model) {
        $attr = "";
        foreach ($model->attributes as $name => $val) {
            $attr .= " attr-$name=
            '{$model->$name}'";
        }
        return "<a href='' data-action='edit' $attr class='text-success' title='Изменить'><i class='fas fa-pencil'></i></a>";
    },
    'format' => 'raw'
]
?>
<script>
    const dir = '<?=mb_strtolower($dirSmall)?>';
    const urlAdd = '<?=Url::to(["/directory/add", "dir" => $dir])?>';
    const urlEdit = '<?=Url::to(["/directory/edit", "dir" => $dir])?>';
</script>
<div class="text-right pb-3 pt-3">
    <button class="btn btn-success" id="addBtn">
        <i class="fas fa-plus-circle"></i>
        Добавить
    </button>
</div>
<?= GridView::widget([
    'dataProvider' => $provider,
    'columns' => $columns
]); ?>


