<?php
/**
 * @var $this yii\web\View
 * @var $model \app\models\projects\PmoProjects
 **/
?>

<div class="row">
    <div class="col">
        <p><strong>Всего задач</strong>: <?= count($model->tasks) ?></p>
        <p><strong>Выполнено вовремя</strong>: <?= count($model->tasksSuccessGood) ?></p>
        <p><strong>Выполненые, просроченные задачи</strong>: <?= count($model->tasksSuccessFail) ?></p>
        <p><strong>Просроченные задачи</strong>: <?= count($model->tasksFail) ?></p>
    </div>
    <div class="col">
        <p><strong>Просроченные задачи:</strong></p>
        <?php foreach ($model->tasksFail as $task): ?>
            <p><?= $task->name ?></p>
            <?php if (isset($task->lastComment->author)): ?>
                <div class="comments">
                    <div class="comment-box">
                          <span class="commenter-name">
                            <?= $task->lastComment->author ?>
                              <span class="comment-time">
                                  <?= Yii::$app->formatter->asDate($task->lastComment->time_created) ?>
                              </span>
                          </span>
                        <p class="comment-txt more">
                            <?= $task->lastComment->text ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <div class="col">
        <p><strong>Активные задачи:</strong></p>
        <?php foreach ($model->tasksActive as $task): ?>
            <p><?= $task->name ?></p>
            <?php if (isset($task->lastComment->author)): ?>
                <div class="comments">
                    <div class="comment-box">
                          <span class="commenter-name">
                            <?= $task->lastComment->author ?>
                              <span class="comment-time">
                                  <?= Yii::$app->formatter->asDate($task->lastComment->time_created) ?>
                              </span>
                          </span>
                        <p class="comment-txt more">
                            <?= $task->lastComment->text ?>
                        </p>
                    </div>
                </div>

            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <div class="col">
        <p><strong>Выполненные задачи:</strong></p>
        <?php foreach ($model->tasksSuccess as $task): ?>
            <p><?= $task->name ?></p>
            <?php if (isset($task->lastComment->author)): ?>
                <div class="comments">
                    <div class="comment-box">
                          <span class="commenter-name">
                            <?= $task->lastComment->author ?>
                              <span class="comment-time">
                                  <?= Yii::$app->formatter->asDate($task->lastComment->time_created) ?>
                              </span>
                          </span>
                        <p class="comment-txt more">
                            <?= $task->lastComment->text ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>
