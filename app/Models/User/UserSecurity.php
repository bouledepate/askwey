<?php

namespace Askwey\App\Models\User;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property string $password_hash
 * @property string $access_token
 * @property string $auth_key
 * @property integer $user_id
 * @property User $user
 */
class UserSecurity extends ActiveRecord
{
    public function rules(): array
    {
        return [
            [['user_id', 'password_hash', 'access_token', 'auth_key'], 'required'],
            [['password_hash', 'access_token', 'auth_key'], 'string'],
            [['password_hash', 'access_token', 'auth_key'], 'trim'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'user_id' => 'Идентификатор пользователя',
            'password_hash' => 'Хешированный пароль пользователя',
            'access_token' => 'Авторизационный токен доступа',
            'auth_key' => 'Уникальный ключ авторизации'
        ];
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function setDefaultParams(int $userId, string $password): self
    {
        $this->user_id = $userId;
        $this->setPassword($password);
        $this->setAccessToken();
        $this->setAuthKey();

        return $this;
    }

    public function validatePassword(string $password): bool
    {
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    private function setPassword(string $password): void
    {
        $this->password_hash = \Yii::$app->security->generatePasswordHash($password);
    }

    private function setAuthKey(): void
    {
        $this->auth_key = \Yii::$app->security->generateRandomString();
    }

    private function setAccessToken(): void
    {
        $this->access_token = \Yii::$app->security->generateRandomString(64);
    }
}