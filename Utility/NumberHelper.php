<?php

declare(strict_types=1);

namespace Brain\Common\Utility;

/**
 * A numeric helper.
 */
final class NumberHelper
{
    /**
     * Clamp a numeric value.
     *
     * @param float|int $input
     * @param float|int $lower
     * @param float|int $upper
     *
     * @return float|int
     */
    public static function clamp($input, $lower, $upper)
    {
        if ($input < $lower) {
            return $lower;
        }

        if ($input > $upper) {
            return $upper;
        }

        return $input;
    }
}
