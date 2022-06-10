<?php

namespace Askwey\App\Components;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@public';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];
}