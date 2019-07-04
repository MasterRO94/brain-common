<?php

namespace Brain\Common\Type;

/**
 * Helper for internal array types.
 */
final class ArrayTypeHelper
{
    /**
     * Check the given array is only containing integers.
     *
     * @param mixed[] $array
     *
     * @return bool
     */
    public static function isIntegerArray(array $array): bool
    {
        if (self::isEmpty($array)) {
            return true;
        }

        foreach ($array as $value)  {
            if (is_integer($value) === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check the given array is empty.
     *
     * @param mixed[] $array
     *
     * @return bool
     */
    public static function isEmpty(array $array): bool
    {
        return $array === [];
    }
}
