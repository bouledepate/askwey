<?php

namespace Askwey\App\Enums;

enum ShownName: int
{
    case USERNAME = 0;
    case PREFERRED_NAME = 1;
    case REAL_NAME = 2;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}