<?php

declare(strict_types=1);

namespace Brain\Common\Math;

/**
 * Rounding helpers.
 */
final class Rounding
{
    /**
     * Round a value to the given precision.
     *
     * @param int|float $numeric
     */
    public static function roundTo($numeric, int $precision): float
    {
        return round($numeric, $precision, PHP_ROUND_HALF_UP);
    }

    /**
     * Round a value to an integer.
     *
     * @param int|float $numeric
     */
    public static function roundToInteger($numeric): int
    {
        return (int) self::roundTo($numeric, 0);
    }

    /**
     * Round the numeric value up.
     *
     * @param int|float $numeric
     */
    public static function ceil($numeric): int
    {
        return (int) ceil($numeric);
    }

    /**
     * Round the numeric value down.
     *
     * @param int|float $numeric
     */
    public static function floor($numeric): int
    {
        return (int) floor($numeric);
    }
}
