<?php

declare(strict_types=1);

namespace Brain\Common\Type;

use Brain\Common\Type\Exception\StringNotNumericException;

/**
 * Helper for internal string types.
 */
final class StringTypeHelper
{
    /**
     * Return the given string as an integer.
     *
     * This conversion is considered strict as it will throw an exception if the string is not numeric.
     * Meaning that this differs from traditional PHP string casting.
     * The entire string must be considered numeric for casting.
     *
     * @throws StringNotNumericException
     *
     * @example "1234"
     * @example "10 downing street" throws
     *
     * This method exists so it can be used with internal functions like array_map().
     */
    public static function toInteger(string $value): int
    {
        if (is_numeric($value) === false) {
            throw StringNotNumericException::create($value);
        }

        return (int) $value;
    }
}
