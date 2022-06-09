<?php

declare(strict_types=1);

namespace Askwey\App\Common\Models\User;

use Askwey\App\Common\Enums\ShownName;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;

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
 * @property ProfileSettings $settings
 */
class UserProfile extends ActiveRecord
{
    public function rules(): array
    {
        return [
            [['preferred_name', 'first_name', 'last_name', 'family_name'], 'string'],
            [['preferred_name', 'first_name', 'last_name', 'family_name'], 'trim'],
            ['avatar', 'file', 'extensions' => ['png', 'jpg', 'jpeg']],
            ['avatar', 'image', 'minHeight' => 100, 'minWidth' => 100, 'maxHeight' => 1200, 'maxWidth' => 1000],
            ['birthday', 'default', 'value' => null],
            ['birthday', 'date', 'format' => 'yyyy-MM-dd']
        ];
    }

    public function beforeSave($insert): bool
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->avatar = \Yii::$container->get('imageUploader')->uploadImageByModel($this, 'avatar');

        return true;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert)
            (new ProfileSettings())->setDefaultParams($this->id)->save();
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

    public function getSettings(): ActiveQuery
    {
        return $this->hasOne(ProfileSettings::class, ['profile_id' => 'id']);
    }

    public function getProfileName(): string
    {
        $name = match ($this->settings->shown_name) {
            ShownName::PREFERRED_NAME->value => $this->preferred_name,
            ShownName::REAL_NAME->value => $this->getRealName(),
            default => $this->user->username
        };

        return $name ?? $this->user->username;
    }

    public function getProfileStatus(): string
    {
        return $this->settings->status ?? 'Расскажите о чём вы сегодня думаете...';
    }

    private function getRealName(): string
    {
        return $this->settings->show_family_name
            ? trim(sprintf("%s %s %s", $this->last_name, $this->first_name, $this->family_name))
            : trim(sprintf("%s %s", $this->first_name, $this->last_name));
    }
}