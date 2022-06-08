<?php

declare(strict_types=1);

namespace Askwey\App\Modules\Main\Models\Forms;

use Askwey\App\Common\Components\Identity;
use Askwey\App\Common\Enums\UserStatus;
use Askwey\App\Common\Models\User\User;
use yii\helpers\ArrayHelper;

class LoginForm extends \yii\base\Model
{
    public ?string $username = null;
    public ?string $password = null;

    private ?Identity $user = null;

    public function rules(): array
    {
        return [
            [['username', 'password'], 'required'],
            ['username', 'validateUser'],
            ['password', 'validatePassword']
        ];
    }

    public function beforeValidate(): bool
    {
        parent::beforeValidate();
        $this->user = $this->getUser();

        return true;
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Логин пользователя',
            'password' => 'Пароль'
        ];
    }

    public function login(): bool
    {
        if (!$this->hasErrors()) {
           return \Yii::$app->user->login($this->user);
        }

        return false;
    }

    public function validateUser(string $attribute)
    {
        if (is_null($this->user)) {
            $this->addError($attribute, 'Пользователь с указанными данными в системе не найден.');
        } else {
            if ($this->user->settings->status == UserStatus::BLOCKED->value)
                $this->addError($attribute, 'Данный пользователь заблокирован в системе.');
            elseif ($this->user->settings->status == UserStatus::DELETED->value)
                $this->addError($attribute, 'Данный пользователь удалён. Для восстановления обратитесь в поддержку.');
        }
    }

    public function validatePassword(string $attribute)
    {
        if (!is_null($this->user) && !$this->user->security->validatePassword($this->password))
            $this->addError($attribute, 'Неправильный пароль.');
    }

    private function getUser(): ?Identity
    {
        if (!empty($this->username))
            return Identity::findIdentityByUsername($this->username);

        return null;
    }
}