<?php

namespace Askwey\App\Models;

use Askwey\App\Enums\QuestionState;
use Askwey\App\Models\User\User;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * @property string $description
 * @property int|null $author_id
 * @property User|null $author Пользователь, кто задаёт вопрос.
 * @property int|null $member_id
 * @property User|null $member Пользователь, которому задают вопрос.
 * @property int $state
 * @property boolean $is_anonymous
 * @property int $date_create
 */
class Question extends ActiveRecord
{
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    self::EVENT_BEFORE_INSERT => ['date_create']
                ],
                'value' => new Expression('CURRENT_TIMESTAMP()'),
            ]
        ];
    }

    public function rules(): array
    {
        return [
            ['description', 'required'],
            ['description', 'string', 'max' => 255],
            ['description', 'trim'],
            [['author_id', 'member_id'], 'exist', 'targetAttribute' => 'id', 'targetClass' => User::class],
            ['is_anonymous', 'boolean'],
            ['state', 'integer'],
            ['state', 'stateValidator']
        ];
    }

    public function beforeValidate()
    {
        if (!parent::beforeValidate())
            return false;

        if (empty($this->author_id))
            $this->is_anonymous = true;

        if (empty($this->member_id)) {
            $this->is_anonymous = false;
        }


        return true;
    }

    public function attributeLabels(): array
    {
        return [
            'description' => 'Текст вопроса',
            'author_id' => 'Автор вопроса',
            'member_id' => 'Для кого вопрос',
            'state' => 'Состояние',
            'is_anonymous' => 'Анонимно',
            'date_create' => 'Дата создания'
        ];
    }

    public function getAnswers()
    {
        return $this->hasMany(Answer::class, ['question_id' => 'id']);
    }

    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

    public function getMember()
    {
        return $this->hasOne(User::class, ['id' => 'member_id']);
    }

    public function stateValidator(string $attribute)
    {
        if (!in_array($this->$attribute, QuestionState::values()))
            $this->addError($attribute, 'Указано неверное значения состояния для вопроса.');
    }

    public function isPublic()
    {
        return empty($this->member_id);
    }

    public function updateState(QuestionState $state): bool
    {
        $this->state = $state->value;
        return $this->update(['state']);
    }
}