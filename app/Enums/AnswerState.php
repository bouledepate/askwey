<?php

namespace Askwey\App\Enums;

enum AnswerState: int
{
    case ACTIVE = 1;
    case HIDDEN_BY_OWNER = 2;
    case DELETED_BY_AUTHOR = 3;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}