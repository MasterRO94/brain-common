<?php

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
     *
     * @return bool
     */
    public static function isValidInput($value): bool
    {
        if (is_null($value)) {
            return false;
        }

        $value = trim($value);

        if (strlen($value) === 0) {
            return false;
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
     *
     * @return bool
     */
    public static function isValidSearchTerm($value): bool
    {
        if (!self::isValidInput($value)) {
            return false;
        }

        if (strlen($value) >= 3) {
            return true;
        }

        return false;
    }
}
