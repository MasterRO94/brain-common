<?php

declare(strict_types=1);

namespace Brain\Common\Enum\Type\Implementation;

use Brain\Common\Enum\Exception\TranslationInvalidForEnumException;
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
     * Define the translation prefix.
     */
    abstract protected static function prefix(): string;

    /**
     * Define the translations for each enum value.
     *
     * @return string[]
     */
    abstract protected static function translations(): array;

    /**
     * {@inheritdoc}
     */
    final public static function translate($value, bool $prefix = true): string
    {
        if (static::has($value) === false) {
            throw ValueInvalidForEnumException::create(static::class, $value, static::all(true));
        }

        $translations = static::translations();

        if (isset($translations[$value]) === false) {
            throw TranslationInvalidForEnumException::create(static::class, $value, static::all(true));
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
    final public function translation(bool $prefix = true): string
    {
        try {
            return static::translate($this->value(), $prefix);
        } catch (ValueInvalidForEnumException $exception) {
            throw DeveloperContractRuntimeException::create($exception); // @codeCoverageIgnore
        } catch (TranslationInvalidForEnumException $exception) {
            throw DeveloperContractRuntimeException::create($exception);
        }
    }
}
