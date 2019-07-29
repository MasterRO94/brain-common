<?php

declare(strict_types=1);

namespace Brain\Common\Assert\Type;

use Brain\Common\Assert\Exception\Type\StringTypeNotEmptyAssertException;

/**
 * Assertions on internal string types.
 */
final class StringTypeAssert
{
    /**
     * Assert the given string is not empty.
     *
     * @throws StringTypeNotEmptyAssertException
     */
    public static function assertNotEmpty(string $value, string $property): void
    {
        if ($value !== '') {
            return;
        }

        throw StringTypeNotEmptyAssertException::create($property);
    }
}
