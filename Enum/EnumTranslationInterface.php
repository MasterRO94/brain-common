<?php

declare(strict_types=1);

namespace Brain\Common\Enum;

use Brain\Common\Enum\Exception\ValueInvalidForEnumException;

/**
 * An enum that can be translated.
 */
interface EnumTranslationInterface
{
    /**
     * Return the translation for the given enum value.
     *
     * @param string|int $value
     *
     * @throws ValueInvalidForEnumException
     */
    public static function translate($value): string;

    /**
     * Return the translation for this enum instance.
     */
    public function translation(): string;
}
