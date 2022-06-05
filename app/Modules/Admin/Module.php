<?php

declare(strict_types=1);

namespace Askwey\App\Modules\Admin;

class Module extends \yii\base\Module
{
    public function init()
    {
        parent::init();
        \Yii::configure($this, require __DIR__ . '\config\main.php');
    }
}