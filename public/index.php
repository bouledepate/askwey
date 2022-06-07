<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

require dirname(__DIR__) . '/vendor/autoload.php';
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

\Dotenv\Dotenv::createImmutable(dirname(__DIR__))->load();

$application = new \yii\web\Application(
    require __DIR__ . '/../config/main.php'
);

$application->run();