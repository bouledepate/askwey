<?php

declare(strict_types=1);

namespace Askwey\App\Common\Models\User;

use Askwey\App\Common\Enums\UserStatus;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
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

    /* @var UserProfile */
    public $profile;

    /* @var UserSecurity */
    public $security;

    /* @var UserSettings */
    public $settings;

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

    public function afterFind()
    {
        parent::afterFind();

        $this->profile = $this->getProfile();
        $this->settings = $this->getSettings();
        $this->security = $this->getSecurity();
    }

    public function getProfile(): ActiveRecord
    {
        return $this->hasOne(UserProfile::class, ['user_id' => 'id'])->one();
    }

    public function getSettings(): ActiveRecord
    {
        return $this->hasOne(UserSettings::class, ['user_id' => 'id'])->one();
    }

    public function getSecurity(): ActiveRecord
    {
        return $this->hasOne(UserSecurity::class, ['user_id' => 'id'])->one();
    }

    public static function findByEmail(string $email): ?self
    {
        $user = self::findOne(['email' => $email]);
        return $user ? new self($user) : null;
    }

    public static function findByUsername(string $username): ?self
    {
        $user = self::findOne(['username' => $username]);
        return $user ? new self($user) : null;
    }
}