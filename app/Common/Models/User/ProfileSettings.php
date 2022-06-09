<?php

namespace Askwey\App\Common\Models\User;

use Askwey\App\Common\Enums\ShownName;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $profile_id
 * @property UserProfile $profile
 * @property int $shown_name
 * @property int $show_family_name
 * @property string $status
 */
class ProfileSettings extends ActiveRecord
{
    public function rules(): array
    {
        return [
            ['profile_id', 'integer'],
            ['profile_id', 'exist', 'targetAttribute' => 'id', 'targetClass' => UserProfile::class],
            ['status', 'string', 'max' => 255],
            ['shown_name', 'in', 'range' => ShownName::values()],
            ['show_family_name', 'boolean']
        ];
    }

    public function getProfile(): ActiveQuery
    {
        return $this->hasOne(UserProfile::class, ['id' => 'profile_id']);
    }

    public function attributeLabels(): array
    {
        return [
            'profile_id' => 'Профиль',
            'status' => 'Статус',
            'shown_name' => 'Отображение имени',
            'show_family_name' => 'Отображение отчества'
        ];
    }

    public function setDefaultParams(int $profileId): self
    {
        $this->profile_id = $profileId;

        return $this;
    }
}