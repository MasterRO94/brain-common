<?php

declare(strict_types=1);

namespace Brain\Common\Enum;

use Brain\Common\Enum\Exception\EmptyEnumException;
use Brain\Common\Enum\Exception\TranslationInvalidForEnumException;
use Brain\Common\Enum\Exception\ValueInvalidForEnumException;
use Brain\Common\Enum\Helper\LegacyEnumHelper;
use Brain\Common\Enum\Type\Implementation\AbstractIntegerEnum;
use Brain\Common\Enum\Type\Implementation\AbstractIntegerTranslationEnum;
use Brain\Common\Enum\Type\Implementation\AbstractStringEnum;
use Brain\Common\Enum\Type\Implementation\AbstractStringTranslationEnum;

use RuntimeException;

/**
 * An abstract ENUM class mainly for use with database columns and translation.
 *
 * @deprecated
 *
 * @see AbstractStringEnum
 * @see AbstractStringTranslationEnum
 * @see AbstractIntegerEnum
 * @see AbstractIntegerTranslationEnum
 */
abstract class AbstractEnum implements
    EnumInterface,
    EnumTranslationInterface
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
        $values = array_filter(array_values(static::getValues()));

        if ($values === []) {
            throw EmptyEnumException::create(static::class);
        }

        return $values;
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
     * @throws ValueInvalidForEnumException
     */
    final public static function translate($value): string
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
     * @throws ValueInvalidForEnumException
     * @throws TranslationInvalidForEnumException
     */
    final public static function valueFromTranslation(string $translation): string
    {
        /** @var string $value */
        $value = LegacyEnumHelper::getValueFromTranslation(static::class, $translation);

        return $value;
    }

    /**
     * @return string[]
     */
    public static function all(bool $sort = false): array
    {
        /** @var string[] $values */
        $values = static::getValues();

        return $values;
    }

    /**
     * @param string $value
     */
    public static function has($value): bool
    {
        return in_array($value, static::getAllValues(), true);
    }

    /**
     * {@inheritdoc}
     */
    public function value()
    {
        throw new RuntimeException('This method is not supported on this enum as its deprecated.');
    }

    /**
     * {@inheritdoc}
     */
    public function translation(): string
    {
        throw new RuntimeException('This method is not supported on this enum as its deprecated.');
    }

    /**
     * {@inheritdoc}
     */
    public function is(EnumInterface $value): bool
    {
        throw new RuntimeException('This method is not supported on this enum as its deprecated.');
    }

    /**
     * {@inheritdoc}
     */
    public function isValue($value): bool
    {
        throw new RuntimeException('This method is not supported on this enum as its deprecated.');
    }
}
