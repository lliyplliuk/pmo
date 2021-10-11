<?php

$params = require __DIR__ . '/params.php';
$db = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/db.php',
    require __DIR__ . '/db-local.php'
);

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'modules' => [
        'gii' => 'yii\gii\Module',
        'rbac' => 'dektrium\rbac\RbacConsoleModule',
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'dbChuk' => ['class' => 'yii\db\Connection',
            'dsn' => 'oci:dbname=//10.73.228.22:1521/pite;charset=UTF8',
            'username' => 'dispatcher',
            'password' => 'disp',
            'schemaMap' => [
                'oci'=> [
                    'class'=>'yii\db\oci\Schema',
                    'defaultSchema' => 'DISPATCHER' //specify your schema here
                ]
            ],
        ],
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
