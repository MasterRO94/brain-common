<?php

declare(strict_types=1);

namespace Brain\Common\Assert\Type;

use Brain\Common\Assert\Exception\Type\ArrayTypeEmptyAssertException;
use Brain\Common\Assert\Exception\Type\ArrayTypeInvalidTypeAssertException;
use Brain\Common\Type\ArrayTypeHelper;

/**
 * Assertion on internal array types.
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
}
