<?php

declare(strict_types=1);

namespace Brain\Common\Enum\Type\Implementation;

use Brain\Common\Enum\Exception\ValueInvalidForEnumException;
use Brain\Common\Enum\Type\StringEnumTranslationInterface;
use Brain\Common\Exception\Developer\DeveloperContractRuntimeException;

/**
 * An enum of strings with translation.
 */
abstract class AbstractStringTranslationEnum extends AbstractStringEnum implements
    StringEnumTranslationInterface
{
    /**
     * Define the translation prefix.
     */
    abstract protected static function prefix(): string;

    /**
     * {@inheritdoc}
     */
    final public static function translate($value): string
    {
        if (static::has($value) === false) {
            throw ValueInvalidForEnumException::create(static::class, $value, static::all(true));
        }

        return sprintf('%s.%s', static::prefix(), $value);
    }

    /**
     * {@inheritdoc}
     */
    final public function translation(): string
    {
        try {
            return static::translate($this->value());
        } catch (ValueInvalidForEnumException $exception) { // @codeCoverageIgnore
            throw DeveloperContractRuntimeException::create($exception); // @codeCoverageIgnore
        }
    }
}
