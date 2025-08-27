<?php

namespace App\Enums;

enum VideoVisibilityEnum: int
{
    case PUBLIC = 1;
    case PROTECTED = 2;
    case PRIVATE = 3;

    public static function fromStringValue(string $case): int
    {
        return match (strtolower($case)) {
            'public' => self::PUBLIC->value,
            'protected' => self::PROTECTED->value,
            'private' => self::PRIVATE->value,
            default => throw new \InvalidArgumentException(__('auth.invalid_visibility') . ' ' . $case),
        };
    }
}