<?php

declare(strict_types=1);

namespace Askwey\App\Common\Enums;

enum UserStatus: int
{
    case INACTIVE = 0;
    case ACTIVE = 1;
    case BLOCKED = 2;
    case DELETED = 3;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}