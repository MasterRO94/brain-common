<?php

declare(strict_types=1);

namespace Brain\Common\Assert\Type;

use Brain\Common\Assert\Exception\Type\ArrayTypeEmptyAssertException;
use Brain\Common\Assert\Exception\Type\ArrayTypeInvalidTypeAssertException;
use Brain\Common\Assert\Exception\Type\ArrayTypeKeyMissingAssertException;
use Brain\Common\Type\ArrayTypeHelper;

/**
 * Assertions on internal array types.
 */
final class ArrayTypeAssert
{
    /**
     * Assert the given array is not empty.
     *
     * @param mixed[] $array
     *
     * @throws ArrayTypeEmptyAssertException
     */
    public static function assertNotEmpty(array $array, string $property): void
    {
        if ($array !== []) {
            return;
        }

        throw ArrayTypeEmptyAssertException::create($property);
    }

    /**
     * Assert the given array has the given key.
     *
     * @param mixed[] $array
     *
     * @throws ArrayTypeKeyMissingAssertException
     */
    public static function assertKeyExists(array $array, string $key, string $property): void
    {
        if (isset($array[$key]) === true) {
            return;
        }

        throw ArrayTypeKeyMissingAssertException::create($key, $property);
    }

    /**
     * Assert the given array is only containing integers.
     *
     * @param mixed[] $array
     *
     * @throws ArrayTypeInvalidTypeAssertException
     */
    public static function assertIntegerArray(array $array, string $property): void
    {
        if (ArrayTypeHelper::isIntegerArray($array) === true) {
            return;
        }

        throw ArrayTypeInvalidTypeAssertException::create($property, 'integer');
    }

    /**
     * Assert the given array is only containing the given class.
     *
     * @param mixed[] $array
     *
     * @throws ArrayTypeInvalidTypeAssertException
     */
    public static function assertClassArray(array $array, string $class, string $property): void
    {
        $matched = true;

        foreach ($array as $item) {
            if (($item instanceof $class) === false) {
                $matched = false;
                break;
            }
        }

        if ($matched === true) {
            return;
        }

        throw ArrayTypeInvalidTypeAssertException::create($property, $class);
    }
}
