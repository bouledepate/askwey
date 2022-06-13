<?php

namespace Askwey\App\Components;

use Askwey\App\Enums\QuestionState;
use Askwey\App\Models\Question;

class QuestionViewHelper
{
    public static function getQuestionTitle(Question $model): string
    {
        $result = '';

        if ($model->state == QuestionState::HIDDEN->value) {
            $result .= "<span class='badge bg-secondary rounded-pill'>Скрытый</span> ";
        }

        if ($model->is_anonymous)
            $result .= "<span class='badge bg-info rounded-pill'>Анонимный</span> ";

        if (!empty($model->member_id)) {
            $result .= "Вопрос для пользователя <a class='text-decoration-none' href='/profile/{$model->member->username}'>{$model->member->profile->getProfileName()}</a>";
        } else {
            $result .= 'Публичный вопрос';
        }


        return $result;
    }
}