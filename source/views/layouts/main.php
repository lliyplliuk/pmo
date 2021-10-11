<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use app\widgets\NavMenu\NavMenu;
use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\bootstrap4\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/sueklogo1.png" type="image/png">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode(!empty($this->title) ? "$this->title - Система управления сервисом" : "Система управления сервисом") ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<header>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar navbar-expand-lg  navbar-dark bg-dark'],
    ]);
    if (Yii::$app->user->isGuest)
        echo Nav::widget([
            'items' => [
                ['label' => 'Войти', 'url' => ['/user/security/login']]
            ],
            'options' => ['class' => 'navbar-nav ml-auto'],
        ]);
    else
        echo NavMenu::widget([
            'options' => ['class' => 'navbar-nav ml-auto'],
            'activateParents' => true,
            'encodeLabels' => false
        ]);;
    NavBar::end();
    ?>
</header>
<main role="main" class="content">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="text-muted bg-light mastfoot mt-auto navbar-fixed-bottom">
    <div class="container">
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
