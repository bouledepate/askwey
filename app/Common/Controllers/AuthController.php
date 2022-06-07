<?php

declare(strict_types=1);

namespace Askwey\App\Common\Controllers;

use Askwey\App\Common\Models\User\User;
use yii\web\Controller;
use yii\web\Response;

class AuthController extends Controller
{
    public $layout = 'auth';

    public function actionSignUp(): string|Response
    {
        $model = new User();

        if ($this->loadData($model) && $model->validate()) {
            $model->save()
                ? \Yii::$app->session->setFlash('success', 'Вы успешно зарегистрировались!')
                : \Yii::$app->session->setFlash('error', 'При регистрации произошла ошибка. Попробуйте позднее.');

            return $this->redirect(['/']);
        }

        return $this->render('index', ['model' => $model]);
    }

    private function loadData(User &$model): bool
    {
        return $model->load(\Yii::$app->request->post())
            && $model->profile->load(\Yii::$app->request->post());
    }
}