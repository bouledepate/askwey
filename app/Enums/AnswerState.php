<?php

namespace Askwey\App\Enums;

enum AnswerState: int
{
    case ACTIVE = 1;
    case HIDDEN = 2;
    case DELETED = 3;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}