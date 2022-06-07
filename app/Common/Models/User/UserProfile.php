<?php

declare(strict_types=1);

namespace Askwey\App\Common\Models\User;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string|null $preferred_name
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $family_name
 * @property string|null $avatar
 * @property string|null $birthday
 * @property integer $user_id
 * @property User $user
 */
class UserProfile extends ActiveRecord
{
    public function rules(): array
    {
        return [
            [['preferred_name', 'first_name', 'last_name', 'family_name'], 'string'],
            [['preferred_name', 'first_name', 'last_name', 'family_name'], 'trim'],
            ['avatar', 'file', 'extensions' => ['png', 'jpg', 'jpeg']],
            ['birthday', 'default', 'value' => null],
            ['birthday', 'date', 'format' => 'yyyy-MM-dd']
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => 'Идентификатор пользователя',
            'preferred_name' => 'Псевдоним',
            'first_name' => 'Имя',
            'last_name' => 'Фамилия',
            'family_name' => 'Отчество',
            'birthday' => 'Дата рождения',
            'avatar' => 'Фотография профиля'
        ];
    }

    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function setUserId(int $id): self
    {
        $this->user_id = $id;

        return $this;
    }
}