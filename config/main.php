<?php

return [
    'id' => 'askwey-app',
    'basePath' => dirname(__DIR__),
    'language' => 'ru-RU',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset'
    ],
    'modules' => require_once 'modules.php',
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
            'rules' => require_once 'routes.php',
        ],
    ]
];