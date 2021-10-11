<?php
/**
 * @var $this yii\web\View
 * @var $project \app\models\projects\PmoProjects
 */


use app\assets\pmoGantt\PmoGanttAsset;
use kartik\select2\Select2;
use yii\bootstrap4\Html;
use yii\bootstrap4\Modal;
use yii\helpers\Url;

PmoGanttAsset::register($this);

$this->title = "Проект $project->name. Диаграмма Гантта";
$this->params['breadcrumbs'][] = [
    'label' => 'Проекты дирекции',
    'url' => ['/pmo'],
];
$this->params['breadcrumbs'][] = $this->title;
?>


    <div id="workSpace"
         style="padding:0px; border:1px solid #e5e5e5;margin:0 5px; height: 100%;"></div>


    <script type="text/javascript">
        function getDemoProject() {
            ret = {
                "tasks": [
                    <?php if(empty(count($project->tasks))): ?>
                    {
                        "id": "PROJECT",
                        "name": "<?=$project->name?>",
                        "progress": 0,
                        "progressByWorklog": false,
                        "relevance": 0,
                        "type": "",
                        "typeId": 0,
                        "description": "",
                        "code": "",
                        "level": 0,
                        "status": "STATUS_ACTIVE",
                        "depends": "",
                        "start": <?=time() * 1000?>,
                        "duration": 1,
                        "end": <?=time() * 1000 ?>,
                        "startIsMilestone": false,
                        "endIsMilestone": false,
                        "collapsed": true,
                        "canWrite": true,
                        "canAdd": true,
                        "canDelete": true,
                        "canAddIssue": true,
                        "assigs": []
                    },
                    <?php endif; ?>
                    <?php foreach($project->tasks as $task):
                    /**
                     * @var $task \app\models\projects\PmoTasks
                     */
                    ?>
                    {
                        "id": "<?=$task->id?>",
                        "name": "<?=str_replace('"', '\\"', $task->name)?>",
                        "progress": <?=$task->progress?>,
                        "progressByWorklog": <?=$task->progress_by_worklog ? 'true' : 'false'?>,
                        "relevance": <?=$task->relevance?>,
                        "type": "<?=$task->type?>",
                        "typeId": <?=(int)$task->type_id?>,
                        "description": "<?=$task->description?>",
                        "comment": `<?=$task->lastComment->text ?? ""?>`,
                        "commentId": <?=$task->lastComment->id ?? 0?>,
                        "commentAuthor": "<?=$task->lastComment->author ?? ""?>",
                        "code": "<?=$task->code?>",
                        "level": <?=$task->level?>,
                        "status": "<?=$task->status?>",
                        "depends": "<?=$task->depends?>",
                        "start": <?=strtotime($task->start) * 1000?>,
                        "startPlan": <?=strtotime($task->startPlan) * 1000?>,
                        "duration": <?=$task->duration?>,
                        "end": <?=strtotime($task->end) * 1000?>,
                        "endPlan": <?=strtotime($task->endPlan) * 1000?>,
                        "startIsMilestone": <?=$task->start_is_milestone ? 'true' : 'false'?>,
                        "endIsMilestone": <?=$task->end_is_milestone ? "true" : "false"?>,
                        "collapsed": <?=$task->collapsed ? "true" : "false"?>,
                        "canWrite": <?=$task->hasEdit ? "true" : "false"?>,
                        "canAdd": <?=$task->hasEdit ? "true" : "false"?>,
                        "canDelete": <?=$task->hasEdit ? "true" : "false"?>,
                        "canAddIssue": <?=$task->hasEdit ? "true" : "false"?>,
                        "assigs": [
                            <?php foreach($task->resource as $res):?>
                            {"id": "<?=$res->id?>", "resourceId": "<?=$res->id_resource?>", "roleId": "1"},
                            <?php endforeach;?>
                        ],
                        "comments": [
                            <?php foreach($task->comments as $comment):?>
                            {
                                "id": "<?=$comment->id?>",
                                "text": `<?=str_replace(["\r\n", "\r", "\n"], "<br />", $comment->text)?>`,
                                "author": "<?=$comment->author?>",
                                "timeCreated": "<?=Yii::$app->formatter->asDateTime($comment->time_created)?>"
                            },
                            <?php endforeach;?>
                        ]
                    },
                    <?php endforeach; ?>
                ],
                "selectedRow": <?=(int)$project->selected_row?>,
                "deletedTaskIds": [],
                "resources": [
                    <?php foreach($project->resources as $res): ?>
                    {"id": "<?=$res->id?>", "name": "<?=$res->name?>", "email": ""},
                    <?php endforeach;?>
                ],
                "roles": [
                    <?php foreach($project->roles as $role): ?>
                    {"id": "<?=$role->id?>", "name": "<?=$role->name?>"},
                    <?php endforeach;?>
                ],
                "canAdd": <?= ($project->can_add) ? "true" : "false" ?>,
                "canWrite": <?=$project->can_write ? "true" : "false"?>,
                "canWriteOnParent": <?=$project->can_write_on_parent ? "true" : "false"?>,
                "zoom": "<?=empty($project->zoom) ? '1M' : $project->zoom?>"
            }

            return ret;
        }

        function saveGanttOnServer(basePlane = 0) {
            changeAnything = false
            var prj = ge.saveProject();
            let myJSON = JSON.stringify(prj);
            $('#modalLoading').data('bs.modal', null)
            $('#modalLoading').modal({
                backdrop: 'static',
                keyboard: false
            });
            $.post("<?=Url::to(["/pmo/save-tasks", "project" => $project->id])?>" + `&basePlane=${basePlane}`, {json: myJSON})
                .done(function () {
                    location.reload()
                })
                .fail(function () {
                    $('#modalLoading').modal('hide')
                    alert('Произошла ошика')
                })
        }
    </script>


    <div id="gantEditorTemplates" style="display:none;">
        <div class="__template__" type="GANTBUTTONS">
            <!--
            <div class="ganttButtonBar noprint">
              <div class="buttons">
                <button onclick="$('#workSpace').trigger('undo.gantt');return false;" class="button textual icon requireCanWrite" title="Отменить ввод"><span class="teamworkIcon">&#39;</span></button>
                <button onclick="$('#workSpace').trigger('redo.gantt');return false;" class="button textual icon requireCanWrite" title="Вернуть ввод"><span class="teamworkIcon">&middot;</span></button>
                <span class="ganttButtonSeparator requireCanWrite requireCanAdd"></span>
                <button onclick="$('#workSpace').trigger('addAboveCurrentTask.gantt');return false;" class="button textual icon requireCanWrite requireCanAdd" title="Вставить перед"><span class="teamworkIcon">l</span></button>
                <button onclick="$('#workSpace').trigger('addBelowCurrentTask.gantt');return false;" class="button textual icon requireCanWrite requireCanAdd" title="Вставить после"><span class="teamworkIcon">X</span></button>
                <span class="ganttButtonSeparator requireCanWrite requireCanInOutdent"></span>
                <button onclick="$('#workSpace').trigger('outdentCurrentTask.gantt');return false;" class="button textual icon requireCanWrite requireCanInOutdent" title="Понизить вложенность"><span class="teamworkIcon">.</span></button>
                <button onclick="$('#workSpace').trigger('indentCurrentTask.gantt');return false;" class="button textual icon requireCanWrite requireCanInOutdent" title="Повысить вложенность"><span class="teamworkIcon">:</span></button>
                <span class="ganttButtonSeparator requireCanWrite requireCanMoveUpDown"></span>
                <button onclick="$('#workSpace').trigger('moveUpCurrentTask.gantt');return false;" class="button textual icon requireCanWrite requireCanMoveUpDown" title="Переместить вверх"><span class="teamworkIcon">k</span></button>
                <button onclick="$('#workSpace').trigger('moveDownCurrentTask.gantt');return false;" class="button textual icon requireCanWrite requireCanMoveUpDown" title="Переместить вниз"><span class="teamworkIcon">j</span></button>
                <span class="ganttButtonSeparator requireCanWrite requireCanDelete"></span>
                <button onclick="$('#workSpace').trigger('deleteFocused.gantt');return false;" class="button textual icon delete requireCanWrite" title="Удалить"><span class="teamworkIcon">&cent;</span></button>
                <span class="ganttButtonSeparator"></span>
                <button onclick="$('#workSpace').trigger('expandAll.gantt');return false;" class="button textual icon " title="Развернуть все"><span class="teamworkIcon">6</span></button>
                <button onclick="$('#workSpace').trigger('collapseAll.gantt'); return false;" class="button textual icon " title="Свернуть все"><span class="teamworkIcon">5</span></button>

              <span class="ganttButtonSeparator"></span>
                <button onclick="$('#workSpace').trigger('zoomMinus.gantt'); return false;" class="button textual icon " title="Уменьшить масштаб"><span class="teamworkIcon">)</span></button>
                <button onclick="$('#workSpace').trigger('zoomPlus.gantt');return false;" class="button textual icon " title="Увеличить масштаб"><span class="teamworkIcon">(</span></button>
              <span class="ganttButtonSeparator"></span>
                <button onclick="$('#workSpace').trigger('print.gantt');return false;" class="button textual icon " title="Печать"><span class="teamworkIcon">p</span></button>
              <span class="ganttButtonSeparator"></span>
                <button onclick="ge.gantt.showCriticalPath=!ge.gantt.showCriticalPath; ge.redraw();return false;" class="button textual icon requireCanSeeCriticalPath" title="Отметить критический путь"><span class="teamworkIcon">&pound;</span></button>
              <span class="ganttButtonSeparator requireCanSeeCriticalPath"></span>
                <button onclick="ge.splitter.resize(.1);return false;" class="button textual icon" ><span class="teamworkIcon">F</span></button>
                <button onclick="ge.splitter.resize(50);return false;" class="button textual icon" ><span class="teamworkIcon">O</span></button>
                <button onclick="ge.splitter.resize(100);return false;" class="button textual icon"><span class="teamworkIcon">R</span></button>
                <span class="ganttButtonSeparator"></span>
                <button onclick="ge.element.toggleClass('colorByStatus' );return false;" class="button textual icon" title="Отключить цвета"><span class="teamworkIcon">&sect;</span></button>
                <button onclick="$('rect.taskLayoutPlan').toggleClass('taskLayoutPlanShow');return false;" title="Отобразить базовый план">
                    <i class="fa fa-tasks" aria-hidden="true"></i>
                </button>
                <button onclick="$('#modalResource').modal('toggle'); return false;" class="button textual requireWrite" title="Редактировать ресурсы"><span class="teamworkIcon">M</span></button>
              <?php if ($project->tasks[0]->hasEdit ?? true): ?>
              <button onclick="saveGanttOnServer();" class="btn btn-success" title="Сохранить">Сохранить</button>
                &nbsp; &nbsp; &nbsp; &nbsp;
                <button onclick="saveGanttOnServer(1);" class="btn btn-info" title="Сохранить как базовый план">Сохранить как БП</button>
                <?php endif ?>
              </div>
            </div>
            -->
        </div>

        <div class="__template__" type="TASKSEDITHEAD"><!--
  <table class="gdfTable" cellspacing="0" cellpadding="0">
    <thead>
    <tr style="height:40px">
      <th class="gdfColHeader" style="width:35px; border-right: none"></th>
      <th class="gdfColHeader" style="width:25px;"></th>
      <th class="gdfColHeader gdfResizable" style="width:300px;">Название</th>
      <th class="gdfColHeader"  align="center" style="width:17px; padding-left: 3px" title="Начало задачи - веха"><span class="teamworkIcon" style="font-size: 8px;">^</span></th>
      <th class="gdfColHeader gdfResizable" style="width:80px;">Начало</th>
      <th class="gdfColHeader"  align="center" style="width:17px; padding-left: 3px" title="Конец задачи - веха"><span class="teamworkIcon" style="font-size: 8px;">^</span></th>
      <th class="gdfColHeader gdfResizable" style="width:80px;">Конец</th>
      <th class="gdfColHeader gdfResizable" style="width:50px;">Продолжительность.</th>
      <th class="gdfColHeader gdfResizable" style="width:30px; padding-left: 3px; padding-right: 3px">%</th>
      <th class="gdfColHeader gdfResizable requireCanSeeDep" style="width:50px;">Зависимоси</th>
      <th class="gdfColHeader gdfResizable" style="width:100px; text-align: left; padding-left: 10px;">Текущий статус</th>
      <th class="gdfColHeader gdfResizable" style="width:1000px; text-align: left; padding-left: 10px;">Ресурсы</th>
    </tr>
    </thead>
  </table>
  --></div>

        <div class="__template__" type="TASKROW"><!--
  <tr id="tid_(#=obj.id#)" taskId="(#=obj.id#)" class="taskEditRow (#=obj.isParent()?'isParent':''#) (#=obj.collapsed?'collapsed':''#)" level="(#=level#)">
    <th class="gdfCell edit" align="right" style="cursor:pointer;"><span class="taskRowIndex">(#=obj.getRow()+1#)</span> <span class="teamworkIcon" style="font-size:12px;" >e</span></th>
    <td class="gdfCell noClip" align="center"><div class="taskStatus cvcColorSquare" status="(#=obj.status#)"></div></td>

    <td class="gdfCell indentCell" style="padding-left:(#=obj.level*10+18#)px;">
      <div class="exp-controller" align="center"></div>
      <input type="text" name="name" value="(#=obj.name#)" placeholder="Название" (#=obj.canWrite?"":"disabled"#)>
    </td>
    <td class="gdfCell" align="center"><input type="checkbox" name="startIsMilestone" (#=obj.canWrite?"":"disabled"#)></td>
    <td class="gdfCell"><input type="text" name="start"  value="" class="date" (#=obj.canWrite?"":"disabled"#)></td>
    <td class="gdfCell" align="center"><input type="checkbox" name="endIsMilestone" (#=obj.canWrite?"":"disabled"#)></td>
    <td class="gdfCell"><input type="text" name="end" value="" class="date" (#=obj.canWrite?"":"disabled"#)></td>
    <td class="gdfCell"><input type="text" name="duration" autocomplete="off" value="(#=obj.duration#)" (#=obj.canWrite?"":"disabled"#)></td>
    <td class="gdfCell"><input type="text" name="progress" class="validated" entrytype="PERCENTILE" (#=obj.canWrite?"":"disabled"#) autocomplete="off" value="(#=obj.progress?obj.progress:''#)" (#=obj.progressByWorklog?"readOnly":""#)></td>
    <td class="gdfCell requireCanSeeDep"><input type="text" name="depends" autocomplete="off" value="(#=obj.depends#)"(#=obj.canWrite?"":"disabled"#)  (#=obj.hasExternalDep?"readonly":""#)></td>
    <td class="gdfCell">
      <input type="text" name="comment" value="(#=obj.comment#)" placeholder="" autocomplete="off" (#=obj.canWrite?"":"disabled"#)>
    </td>
    <td class="gdfCell taskAssigs">(#=obj.getAssigsString()#)</td>
  </tr>
  --></div>

        <div class="__template__" type="TASKEMPTYROW"><!--
  <tr class="taskEditRow emptyRow" >
    <th class="gdfCell" align="right"></th>
    <td class="gdfCell noClip" align="center"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell"></td>
    <td class="gdfCell requireCanSeeDep"></td>
    <td class="gdfCell"></td>
  </tr>
  --></div>

        <div class="__template__" type="TASKBAR"><!--
  <div class="taskBox taskBoxDiv" taskId="(#=obj.id#)" >
    <div class="layout (#=obj.hasExternalDep?'extDep':''#)">
      <div class="taskStatus" status="(#=obj.status#)"></div>
      <div class="taskProgress" style="width:(#=obj.progress>100?100:obj.progress#)%; background-color:(#=obj.progress>100?'red':'rgb(153,255,51);'#);"></div>
      <div class="milestone (#=obj.startIsMilestone?'active':''#)" ></div>

      <div class="taskLabel"></div>
      <div class="milestone end (#=obj.endIsMilestone?'active':''#)" ></div>
    </div>
  </div>
  --></div>


        <div class="__template__" type="CHANGE_STATUS"><!--
    <div class="taskStatusBox">
    <div class="taskStatus cvcColorSquare" status="STATUS_ACTIVE" title="Активная"></div>
    <div class="taskStatus cvcColorSquare" status="STATUS_DONE" title="Выполнена"></div>
    <div class="taskStatus cvcColorSquare" status="STATUS_SUSPENDED" title="Приостановлена"></div>
    </div>
  --></div>


        <div class="__template__" type="TASK_EDITOR"><!--
  <div class="ganttTaskEditor">
    <h2 class="taskData">Редактирование задачи</h2>
    <table cellspacing="1" cellpadding="5" width="100%" class="taskData table" border="0">
        <tr>
            <td colspan="4" valign="top">
                <label for="name" class="required">Название задачи</label><br><input type="text" name="name" id="name"
                                                                                     class="formElements"
                                                                                     autocomplete='off' maxlength=255
                                                                                     style='width:100%' value=""
                                                                                     required="true" oldvalue="1"></td>
        </tr>


        <tr class="dateRow">
            <td nowrap="">
                <div style="position:relative">
                    <label for="start">Начало</label>&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" id="startIsMilestone" name="startIsMilestone" value="yes"> &nbsp;<label
                        for="startIsMilestone">Веха</label>&nbsp;
                    <br><input type="text" name="start" id="start" size="8"
                               class="formElements dateField validated date" autocomplete="off" maxlength="255" value=""
                               oldvalue="1" entrytype="DATE">
                    <span title="calendar" id="starts_inputDate" class="teamworkIcon openCalendar"
                          onclick="$(this).dateField({inputField:$(this).prevAll(':input:first'),isSearchField:false});">m</span>
                </div>
            </td>
            <td nowrap="">
                <label for="end">Окончание</label>&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" id="endIsMilestone" name="endIsMilestone" value="yes"> &nbsp;<label
                    for="endIsMilestone">Веха</label>&nbsp;
                <br><input type="text" name="end" id="end" size="8" class="formElements dateField validated date"
                           autocomplete="off" maxlength="255" value="" oldvalue="1" entrytype="DATE">
                <span title="calendar" id="ends_inputDate" class="teamworkIcon openCalendar"
                      onclick="$(this).dateField({inputField:$(this).prevAll(':input:first'),isSearchField:false});">m</span>
            </td>
            <td nowrap="">
                <label for="duration" class=" ">Продолжительность(дней)</label><br>
                <input type="text" name="duration" id="duration" size="4" class="formElements validated durationdays"
                       title="Duration is in working days." autocomplete="off" maxlength="255" value="" oldvalue="1"
                       entrytype="DURATIONDAYS">&nbsp;
            </td>
            <td>
                <label for="status" class=" ">Статус</label><br>
                <select id="status" name="status" class="taskStatus" status="(#=obj.status#)"
                        onchange="$(this).attr('STATUS',$(this).val());">
                    <option value="STATUS_ACTIVE" class="taskStatus" status="STATUS_ACTIVE">Активная</option>
                    <option value="STATUS_WAITING" class="taskStatus" status="STATUS_WAITING">В ожидании</option>
                    <option value="STATUS_SUSPENDED" class="taskStatus" status="STATUS_SUSPENDED">Приостановлена</option>
                    <option value="STATUS_DONE" class="taskStatus" status="STATUS_DONE">Выполнена</option>
                </select>
            </td>

        </tr>

        <tr>
        <td valign="top" nowrap>
                <label>Прогресс</label><br>
                <input type="text" name="progress" id="progress" size="7" class="formElements validated percentile"
                       autocomplete="off" maxlength="255" value="" oldvalue="1" entrytype="PERCENTILE">
            </td>
            <td colspan="3">
                <label for="description">Описание</label><br>
                <textarea rows="3" cols="30" id="description" name="description" class="formElements"
                          style="width:100%"></textarea>
            </td>
        </tr>

        <tr>
            <td colspan="4">

            </td>
            </tr>

            <tr>
            <td colspan="4">
                <label for="comment">Текущий статус</label><br>
                <textarea rows="3" cols="30" id="comment" name="comment" class="formElements"
                          style="width:100%"></textarea>
                          <input type="hidden" id="commentId"/>
            </td>
        </tr>
        <tr>
            <td colspan="4" id="commentsHistory">
            </td>
        </tr>
    </table>

    <h2>Ресурсы</h2>
    <table cellspacing="1" cellpadding="0" id="assigsTable">
        <tr>
            <th style="width:100px;">Имя</th>
            <th style="width:30px;" id="addAssig"><i style="cursor: pointer" class="fas fa-plus-circle text-success"></i></th>
        </tr>
    </table>

    <div style="text-align: left; padding-top: 20px">
        <span id="saveButton" class="button first" onClick="$(this).trigger('saveFullEditor.gantt');">Сохранить</span>
    </div>

</div>

  --></div>


        <div class="__template__" type="ASSIGNMENT_ROW"><!--
  <tr taskId="(#=obj.task.id#)" assId="(#=obj.assig.id#)" class="assigEditRow" >
    <td ><select name="resourceId"  class="formElements"  ></select></td>
    <td align="center"><span class="teamworkIcon delAssig del" style="cursor: pointer">d</span></td>
  </tr>
  --></div>


        <div class="__template__" type="RESOURCE_EDITOR"><!--
  <div class="resourceEditor" style="padding: 5px;">

    <h2>Команда проекта</h2>
    <table width="100%" id="resourcesTable" class="table">
      <thead>
      <tr>
        <th scope="col">Имя</th>
        <th scope="col">e-mail</th>
        <th scope="col" id="addResource"><i style="cursor: pointer" class="fas fa-plus-circle text-success"></i></th>
      </tr>
      </thead>
    </table>

    <div style="text-align: right; padding-top: 20px"><button id="resSaveButton" class="btn btn-success">Сохранить</button></div>
  </div>
  --></div>


        <div class="__template__" type="RESOURCE_ROW"><!--
  <tr resId="(#=obj.id#)" class="resRow" >
    <td ><input type="text" name="name" value="(#=obj.name#)" style="width:100%;" class="formElements"></td>
    <td><input type="text" name="email" value="(#=obj.email#)" style="width:100%;" class="formElements"></td>
    <td align="center"><span class="teamworkIcon delRes del" style="cursor: pointer">d</span></td>
  </tr>
  --></div>


    </div>

<?php
Modal::begin([
    'id' => 'modalLoading',
    'closeButton' => false,
    'size' => Modal::SIZE_SMALL,
    'options' => [

    ]
]);
?>
    <div class="spinner-border text-primary justify-content-center" style="width: 17rem; height: 17rem;" role="status">
        <span class="sr-only">Loading...</span>
    </div>
<?php
Modal::end();
Modal::begin([
    'id' => 'modalResource',
    //'closeButton' => false,
    //'size' => Modal::SIZE_SMALL,
    'title' => 'Ресурсы проекта'
]);
?>
    <table class="table">
        <?php foreach ($project->resources as $res): ?>
            <tr>
                <td>
                    <?= $res->role ?>
                </td>
                <td>
                    <?= (!empty($res->email)) ? Html::a($res->name, "mailto:" . $res->email) : $res->name ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php if ($project->tasks[0]->hasEdit ?? true): ?>
    <div class="text-right">
        <?= Html::a("Изменить", ['/pmo/edit-project', 'project' => $project->id, '#' => 'res'], ['class' => 'btn btn-info']) ?>
    </div>
<?php
endif;
Modal::end();