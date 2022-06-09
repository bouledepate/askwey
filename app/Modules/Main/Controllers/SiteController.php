<?php

declare(strict_types=1);

namespace Askwey\App\Modules\Main\Controllers;

use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ErrorAction;

class SiteController extends Controller
{
    public function actionIndex(): string
    {
        return $this->render('index');
    }

    public function actionError()
    {
        $exception = \Yii::$app->errorHandler->exception;

        if (!is_null($exception)) {
            return $this->render('error', ['exception' => $exception]);
        }
    }
}