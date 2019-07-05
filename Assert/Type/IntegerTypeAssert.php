<?php

declare(strict_types=1);

namespace Brain\Common\Assert\Type;

use Brain\Common\Assert\Exception\Type\IntegerTypeRangeException;
use Brain\Common\Type\IntegerTypeHelper;

/**
 * Assertions on internal integer types.
 */
final class IntegerTypeAssert
{
    /**
     * Assert the given integer is within a given range.
     *
     * @throws IntegerTypeRangeException
     */
    public static function assertWithinRange(int $value, int $lower, int $upper): void
    {
        if (IntegerTypeHelper::isBetweenInclusive($value, $lower, $upper)) {
            return;
        }

        throw IntegerTypeRangeException::create($value, $lower, $upper);
    }
}
