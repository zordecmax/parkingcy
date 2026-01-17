<?php

namespace App\Enums;

enum PaymentEnum: int
{
    case not_paind = 0;
    case paid = 1;

    public function label(): string
    {
        return match ($this) {
            self::not_paind => 'Not Paid',
            self::paid => 'Paid',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::not_paind => 'danger',
            self::paid => 'success',
        };
    }
    public static function getValues(): array
    {
        return [
            self::not_paind->value => 'Not Paid',
            self::paid->value => 'Paid',
        ];
    }
}
