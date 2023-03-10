<?php

declare(strict_types=1);

namespace Brain\Common\Enum\Type\Implementation;

use Brain\Common\Enum\Exception\ValueInvalidForEnumException;
use Brain\Common\Enum\Type\AbstractEnum;
use Brain\Common\Enum\Type\StringEnumInterface;

/**
 * An enum of strings.
 */
abstract class AbstractStringEnum extends AbstractEnum implements
    StringEnumInterface
{
    /**
     * Define all the values within the enum.
     *
     * @return string[]
     */
    abstract protected static function values(): array;

    /**
     * {@inheritdoc}
     */
    public static function has($value): bool
    {
        return in_array($value, static::values(), true);
    }

    /**
     * Return all values within the enum.
     *
     * @return string[]
     */
    final public static function all(bool $sort = false): array
    {
        $values = static::values();

        if ($sort === true) {
            sort($values);
        }

        return $values;
    }

    /**
     * @throws ValueInvalidForEnumException
     */
    final public function __construct(string $value)
    {
        parent::__construct($value);
    }

    /**
     * {@inheritdoc}
     */
    final public function value(): string
    {
        /** @var string $value */
        $value = parent::value();

        return $value;
    }
}
