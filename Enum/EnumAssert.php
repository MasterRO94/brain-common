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
     *
     * @throws ValueInvalidForEnumException
     */
    public static function validate(string $enum, string $value): void
    {
        /** @var AbstractEnum $class */
        $class = $enum;

        if ($class::isValidValue($value)) {
            return;
        }

        $values = $class::getAllValues();

        throw ValueInvalidForEnumException::create($enum, $value, $values);
    }
}
