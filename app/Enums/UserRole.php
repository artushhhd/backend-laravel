<?php

namespace App\Enums;

enum UserRole: string
{
    case SUPERADMIN = 'superadmin';
    case ADMIN = 'admin';
    case MODERATOR = 'moderator';
    case USER = 'user';

    public function label(): string
    {
        return match($this) {
            self::SUPERADMIN => 'Главный администратор',
            self::ADMIN      => 'Администратор',
            self::MODERATOR  => 'Модератор',
            self::USER       => 'Пользователь',
        };
    }
}
