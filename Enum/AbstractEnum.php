<?php

declare(strict_types=1);

namespace Brain\Common\Enum;

use Brain\Common\Enum\Exception\TranslationInvalidForEnumException;
use Brain\Common\Enum\Exception\ValueInvalidForEnumException;

/**
 * An abstract ENUM class mainly for use with database columns and translation.
 */
abstract class AbstractEnum
{
    /**
     * Return the translation prefix.
     *
     * To disable translations then return null.
     */
    abstract protected static function getTranslationPrefix(): string;

    /**
     * Return the value to translation mapping.
     *
     * @return string[]|null[]
     */
    abstract protected static function getValues(): array;

    /**
     * Return an array of value and translation.
     *
     * @return string[]
     */
    final public static function getMapping(): array
    {
        $prefix = static::getTranslationPrefix();

        $translated = [];

        foreach (self::getAllValues() as $value) {
            $translated[$value] = sprintf('%s.%s', $prefix, $value);
        }

        return $translated;
    }

    /**
     * Return all the values.
     *
     * @return string[]
     */
    final public static function getAllValues(): array
    {
        return array_filter(array_values(static::getValues()));
    }

    /**
     * Return all the translations.
     *
     * @return string[]
     */
    final public static function getAllTranslations(): array
    {
        return array_filter(array_values(static::getMapping()));
    }

    /**
     * Return the translated value.
     *
     * @throws ValueInvalidForEnumException
     */
    final public static function translate(string $value): string
    {
        $mapping = static::getMapping();

        if (isset($mapping[$value]) === false) {
            $values = static::getAllValues();

            throw ValueInvalidForEnumException::create(static::class, $value, $values);
        }

        return $mapping[$value];
    }

    /**
     * Revert a translated canonical value to its value.
     *
     * @throws TranslationInvalidForEnumException
     */
    final public static function value(string $translation): string
    {
        $mapping = array_flip(static::getMapping());

        if (isset($mapping[$translation]) === false) {
            $translations = static::getAllTranslations();

            throw TranslationInvalidForEnumException::create(static::class, $translation, $translations);
        }

        return $mapping[$translation];
    }

    /**
     * Check if the value given is in the enum.
     */
    final public static function isValidValue(string $value): bool
    {
        return in_array($value, static::getAllValues(), true);
    }

    /**
     * Check if the value given is in the enum as a translation.
     * This is more for legacy enum uses where translations were used as form values.
     *
     * @deprecated This should not be needed. Translations should only be used one-way.
     */
    final public static function isValidTranslation(string $value): bool
    {
        return in_array($value, static::getAllTranslations(), true);
    }
}
