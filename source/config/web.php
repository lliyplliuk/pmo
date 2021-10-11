<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$db = yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/db.php',
    require __DIR__ . '/db-local.php'
);

$config = [
    'id' => 'asutp.suek.ru',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'name' => 'ASUTP',
    'language' => 'ru-RU',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
//            'modelMap' => [
////                'LoginForm' => 'app\extensions\dektrium_user\models\LoginForm',
//            ],
            'enableFlashMessages' => false,
            'adminPermission' => 'admin',
            'urlPrefix' => 'user',
            'enableRegistration' => true,
        ],
        'rbac' => [
            'class' => 'dektrium\rbac\RbacWebModule',
        ],
        'gridview' => [
            'class' => 'kartik\grid\Module'
        ],
    ],
    'components' => [
        'formatter' => [
            'dateFormat' => 'dd.MM.yyyy',
            'decimalSeparator' => ',',
            'thousandSeparator' => ' ',
            'currencyCode' => 'RUB',
            'timeZone' => 'Europe/Moscow',
        ],
        'db' => $db,
//        'authManager' => [
//            'class' => 'dektrium\rbac\RbacWebModule',
//        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/extensions/dektrium_user/views',
                    '@dektrium/rbac/views' => '@app/extensions/dektrium_rbac/views',
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '12qwASZX',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'linkAssets' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['172.*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
