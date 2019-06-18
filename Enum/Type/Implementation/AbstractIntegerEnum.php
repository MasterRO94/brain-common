<?php

declare(strict_types=1);

namespace Brain\Common\Enum\Type\Implementation;

use Brain\Common\Enum\Exception\ValueInvalidForEnumException;
use Brain\Common\Enum\Type\AbstractEnum;
use Brain\Common\Enum\Type\IntegerEnumInterface;

/**
 * An enum of integers.
 */
abstract class AbstractIntegerEnum extends AbstractEnum implements
    IntegerEnumInterface
{
    /**
     * Define all the values within the enum.
     *
     * @return int[]
     */
    abstract protected static function values(): array;

    /**
     * {@inheritdoc}
     */
    final public static function has($value): bool
    {
        return in_array($value, static::values(), true);
    }

    /**
     * {@inheritdoc}
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
    final public function __construct(int $value)
    {
        parent::__construct($value);
    }

    /**
     * {@inheritdoc}
     */
    final public function value(): int
    {
        /** @var int $value */
        $value = parent::value();

        return $value;
    }
}
