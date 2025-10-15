<?php

namespace App\Enums;

enum UserType : string
{
    case ADMIN = 'admin';
    case USER = 'user';
    case GUEST = 'guest';

    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Administrator',
            self::USER => 'Registered User',
            self::GUEST => 'Guest User',
        };
    }

}
