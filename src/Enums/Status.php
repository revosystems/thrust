<?php

declare(strict_types=1);

namespace BadChoice\Thrust\Enums;

enum Status: int
{
    case OK = 0;
    case WARNING = 1;
    case ERROR = 2;

    public function color(): string
    {
        return match ($this) {
            self::OK => '#8AB62B',
            self::WARNING => '#F4DB4C',
            self::ERROR => '#E44848',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::OK => 'fa fa-check-circle',
            self::WARNING => 'fa fa-exclamation-circle',
            self::ERROR => 'fa fa-times-circle',
        };
    }

    public function html(string $tooltip): string
    {
        return "<i class='{$this->icon()}' style='font-size: 18px; color: {$this->color()};' title='$tooltip'></i>";
    }
}
