<?php

namespace App\Enums;

enum ProjectStatus: string
{
    //
    case ONGOING = 'ongoing';
    case COMPLETED = 'completed';
    case TERMINATED = 'terminated';
    case CONTINUING = 'continuing';
    case GRADUATED = 'graduated';
    case GRACE_PERIOD = 'grace_period';
    case LIQUIDATED = 'liquidated';
    case UNLIQUIDATED = 'unliquidated';

    public function label(): string
    {
        return match ($this) {
            self::ONGOING => 'ongoing',
            self::COMPLETED => 'completed',
            self::TERMINATED => 'terminated',
            self::CONTINUING => 'continuing',
            self::GRADUATED => 'graduated',
            self::GRACE_PERIOD => 'grace_period',
            self::LIQUIDATED => 'liquidated',
            self::UNLIQUIDATED => 'unliquidated',
        };
    }
}
