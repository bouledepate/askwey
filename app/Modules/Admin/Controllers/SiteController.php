<?php

declare(strict_types=1);

namespace Askwey\App\Modules\Admin\Controllers;

use yii\web\Controller;

class SiteController extends Controller
{
    public function actionIndex(): string
    {
        return $this->render('index');
    }
}