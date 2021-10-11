var ge;
$(function () {
    var canWrite = true; //this is the default for test purposes

    // here starts gantt initialization
    ge = new GanttMaster();
    ge.set100OnClose = true;

    ge.shrinkParent = true;

    ge.init($("#workSpace"));
    loadI18n(); //overwrite with localized ones

    //in order to force compute the best-fitting zoom level
    delete ge.gantt.zoom;

    var project = loadFromLocalStorage();

    if (!project.canWrite)
        $(".ganttButtonBar button.requireWrite").attr("disabled", "true");

    ge.loadProject(project);
    ge.checkpoint(); //empty the undo stack

    window.onbeforeunload = closeOrNot;


});

function closeOrNot(e) {
    if(changeAnything) {
        if (!e) e = window.event;
        e.cancelBubble = true;
        e.returnValue = '';
        if (e.stopPropagation) {
            e.stopPropagation();
            e.preventDefault();
        }
    }
}



function loadFromLocalStorage() {
    return getDemoProject();
}


function showBaselineInfo(event, element) {
    //alert(element.attr("data-label"));
    $(element).showBalloon(event, $(element).attr("data-label"));
    ge.splitter.secondBox.one("scroll", function () {
        $(element).hideBalloon();
    })
}

$.JST.loadDecorator("RESOURCE_ROW", function (resTr, res) {
    resTr.find(".delRes").click(function () {
        $(this).closest("tr").remove()
    });
});

$.JST.loadDecorator("ASSIGNMENT_ROW", function (assigTr, taskAssig) {
    var resEl = assigTr.find("[name=resourceId]");
    var opt = $("<option>");
    resEl.append(opt);
    for (var i = 0; i < taskAssig.task.master.resources.length; i++) {
        var res = taskAssig.task.master.resources[i];
        opt = $("<option>");
        opt.val(res.id).html(res.name);
        if (taskAssig.assig.resourceId == res.id)
            opt.attr("selected", "true");
        resEl.append(opt);
    }
    var roleEl = assigTr.find("[name=roleId]");
    for (var i = 0; i < taskAssig.task.master.roles.length; i++) {
        var role = taskAssig.task.master.roles[i];
        var optr = $("<option>");
        optr.val(role.id).html(role.name);
        if (taskAssig.assig.roleId == role.id)
            optr.attr("selected", "true");
        roleEl.append(optr);
    }

    if (taskAssig.task.master.permissions.canWrite && taskAssig.task.canWrite) {
        assigTr.find(".delAssig").click(function () {
            var tr = $(this).closest("[assId]").fadeOut(200, function () {
                $(this).remove()
            });
        });
    }

});


function loadI18n() {
    GanttMaster.messages = {
        "CANNOT_WRITE": "Нет прав для изменения данной задачи:",
        "CHANGE_OUT_OF_SCOPE": "Обновление проекта невозможно, так как у вас нет прав на обновление родительского проекта..",
        "START_IS_MILESTONE": "Начальная дата - веха.",
        "END_IS_MILESTONE": "Дата окончания - веха\.",
        "TASK_HAS_CONSTRAINTS": "У задачи есть ограничения.",
        "GANTT_ERROR_DEPENDS_ON_OPEN_TASK": "Ошибка: есть зависимость от открытой задачи.",
        "GANTT_ERROR_DESCENDANT_OF_CLOSED_TASK": "Ошибка: из-за потомка закрытой задачи.",
        "TASK_HAS_EXTERNAL_DEPS": "Эта задача имеет внешние зависимости.",
        "GANNT_ERROR_LOADING_DATA_TASK_REMOVED": "GANNT_ERROR_LOADING_DATA_TASK_REMOVED",
        "CIRCULAR_REFERENCE": "Цикличная ссылка.",
        "CANNOT_DEPENDS_ON_ANCESTORS": "Не может зависит от предков.",
        "INVALID_DATE_FORMAT": "Вставленные данные недопустимы для формата поля.",
        "GANTT_ERROR_LOADING_DATA_TASK_REMOVED": "Произошла ошибка при загрузке данных. Задача удалена.",
        "CANNOT_CLOSE_TASK_IF_OPEN_ISSUE": "Невозможно закрыть задачу с открытыми проблемами",
        "TASK_MOVE_INCONSISTENT_LEVEL": "Вы не можете обмениваться заданиями разной глубины.",
        "CANNOT_MOVE_TASK": "CANNOT_MOVE_TASK",
        "PLEASE_SAVE_PROJECT": "PLEASE_SAVE_PROJECT",
        "GANTT_SEMESTER": "Полугодие",
        "GANTT_SEMESTER_SHORT": "п.",
        "GANTT_QUARTER": "Квартал",
        "GANTT_QUARTER_SHORT": "кв.",
        "GANTT_WEEK": "Неделя",
        "GANTT_WEEK_SHORT": "нед."
    };
}


function createNewResource(el) {
    var row = el.closest("tr[taskid]");
    var name = row.find("[name=resourceId_txt]").val();
    var url = contextPath + "/applications/teamwork/resource/resourceNew.jsp?CM=ADD&name=" + encodeURI(name);

    openBlackPopup(url, 700, 320, function (response) {
        //fillare lo smart combo
        if (response && response.resId && response.resName) {
            //fillare lo smart combo e chiudere l'editor
            row.find("[name=resourceId]").val(response.resId);
            row.find("[name=resourceId_txt]").val(response.resName).focus().blur();
        }

    });
}