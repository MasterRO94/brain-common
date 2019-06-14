<?php

declare(strict_types=1);

namespace Brain\Common\Enum\Type;

use Brain\Common\Enum\EnumTranslationInterface;
use Brain\Common\Enum\Exception\ValueInvalidForEnumException;

/**
 * A integer enum that can be translated.
 *
 * Used to enforce strict typing on the overridden methods.
 * This can probably be fixed up a bit with PHP 7.4 covariance/contra-variance changes.
 */
interface IntegerEnumTranslationInterface extends
    EnumTranslationInterface
{
    /**
     * Return the translation for the given enum value.
     *
     * @param int $value
     *
     * @throws ValueInvalidForEnumException
     */
    public static function translate($value): string;
}
