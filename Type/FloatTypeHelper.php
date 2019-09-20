<?php

declare(strict_types=1);

namespace Brain\Common\Type;

use Brain\Common\Math\Rounding;

/**
 * Helper for internal float types.
 */
final class FloatTypeHelper
{
    /**
     * Return the given float as an integer.
     *
     * This will essentially floor the value to an integer.
     * Idea being it just "chops" the decimal point and trailing numbers off.
     *
     * This method exists so it can be used with internal functions like array_map().
     */
    public static function toInteger(float $value): int
    {
        return Rounding::floor($value);
    }
}
