<?php

namespace Brain\Common\Enum;

/**
 * An abstract ENUM class mainly for use with database columns and translation.
 *
 * @api
 */
abstract class AbstractEnum
{
    /**
     * Return the translation prefix.
     *
     * To disable translations then return null.
     *
     * @return string|null
     *
     * @api
     */
    abstract protected static function getTranslationPrefix(): string;

    /**
     * Return the value to translation mapping.
     *
     * @return array
     *
     * @api
     */
    abstract protected static function getValues(): array;

    /**
     * Return an array of value and translation.
     *
     * @return array
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
     * @param string $value
     *
     * @return string
     */
    final public static function translate(string $value): string
    {
        $mapping = static::getMapping();

        if ($mapping[$value]) {
            return $mapping[$value];
        }

        return $value;
    }

    /**
     * Revert a translated canonical value to its value.
     *
     * @param string $translation
     *
     * @return string
     */
    final public static function value(string $translation): string
    {
        $mapping = array_flip(static::getMapping());

        if ($mapping[$translation]) {
            return $mapping[$translation];
        }

        return $translation;
    }
}
