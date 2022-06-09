<?php

declare(strict_types=1);

namespace Askwey\App\Modules\Main\Controllers;

use yii\web\Controller;
use Askwey\App\Common\Models\User\User;
use yii\web\NotFoundHttpException;

class ProfileController extends Controller
{
    public ?User $user = null;

    public function actionIndex(string $username)
    {
        $this->getUser($username);
        return $this->render('index', ['model' => $this->user]);
    }

    private function getUser(string $username): void
    {
        $user = User::findByUsername($username);

        if (!$user)
            throw new NotFoundHttpException("Пользователь $username не найден.");

        $this->user = $user;
    }
}