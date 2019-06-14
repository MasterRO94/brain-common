<?php

declare(strict_types=1);

namespace Brain\Common\Enum\Type\Implementation;

use Brain\Common\Enum\Exception\ValueInvalidForEnumException;
use Brain\Common\Enum\Type\IntegerEnumInterface;

/**
 * An enum of integers.
 */
abstract class AbstractIntegerEnum implements
    IntegerEnumInterface
{
    /** @var int */
    private $value;

    /**
     * Define all the values within the enum.
     *
     * @return int[]
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
    public function __construct(int $value)
    {
        if (static::has($value) === false) {
            throw ValueInvalidForEnumException::create(static::class, $value, static::values());
        }

        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function value(): int
    {
        return $this->value;
    }
}
