<?php

declare(strict_types=1);

namespace Brain\Common\Enum\Assert;

use Brain\Common\Enum\EnumInterface;
use Brain\Common\Enum\Exception\ValueInvalidForEnumException;

/**
 * Enum related assertions.
 */
final class EnumAssert
{
    /**
     * Validate that the value is allowed for the given enum.
     *
     * @param string|int $value
     *
     * @throws ValueInvalidForEnumException
     */
    public static function validate(string $enum, $value): void
    {
        /** @var EnumInterface $class */
        $class = $enum;

        if ($class::has($value)) {
            return;
        }

        throw ValueInvalidForEnumException::create($enum, $value, $class::all(true));
    }
}
