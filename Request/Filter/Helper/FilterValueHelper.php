<?php

declare(strict_types=1);

namespace Brain\Common\Request\Filter\Helper;

/**
 * A helper for filter input.
 */
final class FilterValueHelper
{
    /**
     * Check the value.
     *
     * @param mixed $value
     */
    public static function isValidInput($value): bool
    {
        if ($value === null) {
            return false;
        }

        if (is_string($value)) {
            $value = trim($value);

            if (strlen($value) === 0) {
                return false;
            }
        }

        if (is_numeric($value)) {
            return true;
        }

        return (bool) $value;
    }

    /**
     * Check the value is a valid search term.
     *
     * @param mixed $value
     */
    public static function isValidSearchTerm($value): bool
    {
        if (!self::isValidInput($value)) {
            return false;
        }

        if (is_string($value) && (strlen($value) >= 3)) {
            return true;
        }

        return false;
    }
}
