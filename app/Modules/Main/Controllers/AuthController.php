<?php

declare(strict_types=1);

namespace Askwey\App\Modules\Main\Controllers;

use Askwey\App\Common\Components\Identity;
use Askwey\App\Common\Models\User\User;
use Askwey\App\Modules\Main\Models\Forms\LoginForm;
use yii\web\Controller;
use yii\web\Response;

class AuthController extends Controller
{
    public $layout = 'auth';

    public function behaviors()
    {
        return parent::behaviors(); // TODO: Change the autogenerated stub
    }

    public function actionSignUp(): string|Response
    {
        $model = new User();

        if ($this->loadUserData($model) && $model->validate()) {
            $model->save()
                ? \Yii::$app->session->setFlash('success', 'Вы успешно зарегистрировались.')
                : \Yii::$app->session->setFlash('error', 'При регистрации произошла ошибка. Попробуйте позднее.');

            \Yii::$app->user->login(new Identity($model));

            return $this->redirect(['/']);
        }

        return $this->render('sign-up', ['model' => $model]);
    }

    public function actionSignIn(): string|Response
    {
        $model = new LoginForm();

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $model->login()
                ? \Yii::$app->session->setFlash('success', 'Вы успешно авторизовались.')
                : \Yii::$app->session->setFlash('error', 'При авторизации произошла ошибка.');

            return $this->redirect(['/']);
        }

        return $this->render('sign-in', ['model' => $model]);
    }

    public function actionSignOut(): Response
    {
        \Yii::$app->user->logout();
        return $this->redirect(['/']);
    }

    private function loadUserData(User &$model): bool
    {
        return $model->load(\Yii::$app->request->post())
            && $model->profile->load(\Yii::$app->request->post());
    }
}