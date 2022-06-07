<?php

declare(strict_types=1);

namespace Askwey\App\Common\Models\User;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property UserProfile $profile
 * @property UserSecurity $security
 * @property UserSettings $settings
 */
class User extends ActiveRecord
{
    public ?string $password = null;
    public ?string $passwordRepeat = null;

    public UserProfile $profile;
    public UserSecurity $security;
    public UserSettings $settings;

    public function __construct($config = [])
    {
        $this->declareAdditionalModels();
        parent::__construct($config);
    }

    private function declareAdditionalModels(): void
    {
        $this->profile = new UserProfile();
        $this->security = new UserSecurity();
        $this->settings = new UserSettings();
    }

    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    self::EVENT_BEFORE_UPDATE => ['updated_at']
                ],
                'value' => new Expression('CURRENT_TIMESTAMP()'),
            ]
        ];
    }

    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            $this->profile->setUserId($this->id)->save();
            $this->security->setDefaultParams($this->id, $this->password)->save();
            $this->settings->setDefaultParams($this->id)->save();
        }
    }

    public function rules(): array
    {
        return [
            [['username', 'email', 'password', 'passwordRepeat'], 'required'],
            [['username', 'email', 'password', 'passwordRepeat'], 'string'],
            [['username', 'email', 'password', 'passwordRepeat'], 'trim'],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают.'],
            ['profile', 'profileValidate']
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'username' => 'Логин пользователя',
            'email' => 'Электронная почта',
            'password' => 'Пароль',
            'passwordRepeat' => 'Повторение пароля',
            'profile' => 'Настройки профиля'
        ];
    }

    public function profileValidate(string $attribute): void
    {
        if (!$this->profile->validate()) {
            foreach ($this->profile->getErrors() as $profileAttribute => $error) {
                $this->profile->addError($profileAttribute, $error);
            }

            $this->addError($attribute, 'Ошибка валидации данных профиля.');
        }
    }
}