<?php

declare(strict_types=1);

namespace Brain\Common\Enum\Type\Implementation;

use Brain\Common\Enum\Exception\ValueInvalidForEnumException;
use Brain\Common\Enum\Type\IntegerEnumTranslationInterface;
use Brain\Common\Exception\Developer\DeveloperContractRuntimeException;

/**
 * An enum of integers with translation.
 */
abstract class AbstractIntegerTranslationEnum extends AbstractIntegerEnum implements
    IntegerEnumTranslationInterface
{
    /**
     * {@inheritdoc}
     */
    public static function translate($value, bool $prefix = true): string
    {
        if (static::has($value) === false) {
            throw ValueInvalidForEnumException::create(static::class, $value, static::values());
        }

        $translations = static::translations();

        if (isset($translations[$value]) === false) {
            throw ValueInvalidForEnumException::create(static::class, $value, static::values());
        }

        $translated = $translations[$value];

        if ($prefix === false) {
            return $translated;
        }

        return sprintf('%s.%s', static::prefix(), $translated);
    }

    /**
     * {@inheritdoc}
     */
    public function translation(bool $prefix = true): string
    {
        try {
            return static::translate($this->value(), $prefix);
        } catch (ValueInvalidForEnumException $exception) {
            throw DeveloperContractRuntimeException::create($exception);
        }
    }

    /**
     * Define the translations for each enum value.
     *
     * @return string[]
     */
    abstract protected static function translations(): array;

    /**
     * Define the translation prefix.
     */
    abstract protected static function prefix(): string;
}
