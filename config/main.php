<?php

$modules = require_once 'modules.php';
$routes = require_once 'routes.php';
$database = require_once 'database.php';
$params = require_once 'params.php';

return [
    'id' => 'askwey-app',
    'basePath' => dirname(__DIR__),
    'language' => 'ru-RU',
    'controllerNamespace' => 'Askwey\App\Controllers',
    'viewPath' => dirname(__DIR__) . '/app/Views',
    'layoutPath' => dirname(__DIR__) . '/app/Views/layouts',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
        '@public' => dirname(__DIR__) . '/public',
        '@static' => dirname(__DIR__) . '/static'
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'wmYG0NTg6j2ZYqe2pVu8zsQfJs5ucyouNM1RdFDu'
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
            'rules' => $routes,
        ],
        'db' => $database,
        'assetManager' => [
            'class' => \yii\web\AssetManager::class,
            'basePath' => "@public/assets",
            'bundles' => [
                'yii\bootstrap5\BootstrapAsset' => [
                    'css' => [
                        YII_ENV_DEV ? 'css/bootstrap.css' : 'css/bootstrap.min.css',
                    ]
                ],
                'yii\bootstrap5\BootstrapPluginAsset' => [
                    'js' => [
                        YII_ENV_DEV ? 'js/bootstrap.bundle.js' : 'js/bootstrap.bundle.min.js',
                    ]
                ],
                'yii\web\JqueryAsset' => [
                    'js' => [
                        YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js',
                    ]
                ],
            ],
        ],
        'user' => [
            'identityClass' => \Askwey\App\Components\Identity::class,
            'loginUrl' => ['auth/sign-in'],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error'
        ]
    ],
    'modules' => $modules,
    'params' => $params,
    'container' => [
        'definitions' => [
            'imageUploader' => [
                'class' => \Askwey\App\Components\ImageUploader::class
            ]
        ]
    ]
];