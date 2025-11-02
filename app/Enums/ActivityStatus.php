<?php

namespace App\Enums;

enum ActivityStatus: string
{
    //
    // 'planned',
    // 'ongoing',
    // 'completed',
    // 'cancelled',
    // 'rescheduled',
    case PLANNED = 'planned';
    case ONGOING = 'ongoing';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case RESCHEDULED = 'rescheduled';

    public function label(): string
    {
        return match ($this) {
            self::PLANNED => 'Planned',
            self::ONGOING => 'Ongoing',
            self::COMPLETED => 'Completed',
            self::CANCELLED => 'Cancelled',
            self::RESCHEDULED => 'Rescheduled',
        };
    }
}
