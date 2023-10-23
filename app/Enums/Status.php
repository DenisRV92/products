<?php

namespace App\Enums;

enum Status: string
{
    case AVAILABLE = 'available';
    case UNAVAILABLE = 'unavailable';

    public function readable(): string
    {
        return match ($this) {
            Status::AVAILABLE => 'Доступен',
            Status::UNAVAILABLE => 'Недоступен',
            default => 'Доступен'
        };
    }

    public static function fromString($string): self
    {
        return match ($string) {
            'Доступен' => Status::AVAILABLE,
            'Недоступен' => Status::UNAVAILABLE,
            default => Status::AVAILABLE
        };
    }
}
