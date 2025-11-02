<?php

namespace App\Enums;

enum ProgramType: string
{
    case SETUP = 'setup';
    case LGIA = 'lgia';
    case CEST = 'cest';
    case SSCP = 'sscp';

    public function label(): string
    {
        return match ($this) {
            self::SETUP => 'Small Enterprise Technology Upgrading Program',
            self::LGIA => 'Local Grants-in-Aid',
            self::CEST => 'Community Empowerment through Science and Technology',
            self::SSCP => 'Smart and Sustainable Communities Program',
        };
    }
}
