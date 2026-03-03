<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case USER = 'user';

    public static function labels(): array
    {
        return [
            self::ADMIN->value => __('home.admin'),
            self::USER->value => __('home.user'),
        ];
    }
}
