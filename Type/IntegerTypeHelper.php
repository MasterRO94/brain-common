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
     * Cast the value as integer.
     *
     * This method exists so it can be used with internal functions like array_map().
     *
     * @param string $in
     */
    public static function asInteger($in): int
    {
        return (int) $in;
    }
}
