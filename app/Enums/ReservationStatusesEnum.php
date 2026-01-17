<?php

namespace App\Enums;

enum ReservationStatusesEnum: int
{
    case pending = 0;
    case confirmed = 1;
    case cancelled = 2;
    case completed = 3;

    public static function getValues(): array
    {
        return [
            self::pending->value => 'Pending',
            self::confirmed->value => 'Confirmed',
            self::cancelled->value => 'Cancelled',
            self::completed->value => 'Completed',
        ];
    }
}
