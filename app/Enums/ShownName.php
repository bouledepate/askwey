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

    public static function titles(): array
    {
        return [
            self::USERNAME->value => 'Имя аккаунта',
            self::PREFERRED_NAME->value => 'Псевдоним',
            self::REAL_NAME->value => 'Настоящее имя'
        ];
    }

    public static function getTitie(int $option): string
    {
        return match ($option) {
            self::USERNAME->value => 'Имя аккаунта',
            self::PREFERRED_NAME->value => 'Псевдоним',
            self::REAL_NAME->value => 'Настоящее имя',
            default => '(Не определено)'
        };
    }
}