<?php

declare(strict_types=1);

namespace Askwey\App\Components;

use Askwey\App\Enums\UserStatus;
use Askwey\App\Models\User\User;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

class Identity implements ExtendedIdentityInterface
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function __get(string $name): mixed
    {
        return $this->user->$name;
    }

    public function __call(string $name, array $arguments): mixed
    {
        return $this->user->$name($arguments);
    }

    public static function findIdentity($id): ?self
    {
        $user = User::findOne(['id' => $id]);
        return $user ? new self($user) : null;
    }

    public static function findIdentityByAccessToken($token, $type = null): never
    {
        throw new NotSupportedException(__METHOD__ . ' not supported.');
    }

    public static function findIdentityByUsername($username): ?self
    {
        $user = User::findOne(['username' => $username]);
        return $user ? new self($user) : null;
    }

    public function getId(): int
    {
        return $this->user->id;
    }

    public function getAuthKey(): string
    {
        return $this->user->security->auth_key;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->user->security->auth_key === $authKey;
    }
}