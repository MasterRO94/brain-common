<?php

declare(strict_types=1);

namespace Brain\Common\Enum;

use Brain\Common\Enum\Exception\ValueInvalidForEnumException;

/**
 * Enum related assertions.
 */
final class EnumAssert
{
    /**
     * Validate that the value is allowed for the given enum.
     */
    public static function validate(string $enum, string $value): void
    {
        /** @var AbstractEnum $class */
        $class = $enum;

        $values = $class::getAllValues();

        if (in_array($value, $values)) {
            return;
        }

        throw ValueInvalidForEnumException::create($enum, $value, $values);
    }
}
