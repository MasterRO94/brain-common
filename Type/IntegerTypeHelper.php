<?php

declare(strict_types=1);

namespace Brain\Common\Type;

/**
 * Helper for internal integer types.
 */
final class IntegerTypeHelper
{
    /**
     * Check the given value is between the lower and upper bounds.
     */
    public static function isBetweenInclusive(int $value, int $lower, int $upper): bool
    {
        if ($value < $lower) {
            return false;
        }

        if ($value > $upper) {
            return false;
        }

        return true;
    }

    /**
     * Cast the given integer to a string.
     *
     * This method exists so it can be used with internal functions like array_map().
     */
    public static function toString(int $value): string
    {
        return (string) $value;
    }

    /**
     * Clamp the value within boundaries.
     */
    public static function clamp(int $value, int $lower, int $upper): int
    {
        if ($value < $lower) {
            return $lower;
        }

        if ($value > $upper) {
            return $upper;
        }

        return $value;
    }
}
