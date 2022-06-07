<?php

namespace Askwey\App\Common\Models\User;

use Askwey\App\Common\Enums\UserStatus;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property integer $user_id
 * @property User $user
 * @property integer $status
 * @property integer|boolean $is_readonly
 */
class UserSettings extends ActiveRecord
{
    public function rules(): array
    {
        return [
            [['user_id'], 'required'],
            [['status'], 'integer'],
            ['is_readonly', 'boolean'],
            ['status', 'in', 'range' => UserStatus::values()]
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'user_id' => 'Идентификатор пользователя',
            'status' => 'Состояние аккаунта',
            'is_readonly' => 'Режим чтения'
        ];
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function setDefaultParams(int $userId): self
    {
        $this->user_id = $userId;
        $this->status = UserStatus::ACTIVE->value;
        $this->is_readonly = false;

        return $this;
    }
}