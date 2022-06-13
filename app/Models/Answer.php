<?php

namespace Askwey\App\Models;

use Askwey\App\Enums\AnswerState;
use Askwey\App\Models\User\User;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

class Answer extends ActiveRecord
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
            [['description', 'question_id'], 'required'],
            [['description'], 'string'],
            [['description'], 'trim'],
            [['author_id'], 'exist', 'targetAttribute' => 'id', 'targetClass' => User::class],
            [['is_anonymous', 'is_public'], 'boolean'],
            ['state', 'integer'],
            ['state', 'stateValidator']
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'description' => 'Ответ на вопрос',
            'author_id' => 'Автор ответа',
            'state' => 'Состояние',
            'is_anonymous' => 'Анонимно',
            'is_public' => 'Отображать в профиле',
            'date_create' => 'Дата создания'
        ];
    }

    public function stateValidator(string $attribute)
    {
        if (!in_array($this->$attribute, AnswerState::values()))
            $this->addError($attribute, 'Указано неверное значение состояния для ответа');
    }
}