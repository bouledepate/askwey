<?php

namespace Askwey\App\Enums;

enum QuestionState: int
{
    case NEW = 1;
    case HAS_ANSWER = 2;
    case HIDDEN = 3;
    case DELETED = 4;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}