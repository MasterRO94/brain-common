<?php

declare(strict_types=1);

namespace Brain\Common\Enum\Type;

use Brain\Common\Assert\Type\ArrayTypeAssert;
use Brain\Common\Enum\EnumInterface;
use Brain\Common\Enum\Exception\ValueInvalidForEnumException;

use ReflectionObject;

/**
 * An enum that is not bound by type.
 *
 * Would not recommend using, this is just meant to implement some common logic between typed enums.
 *
 * @internal
 */
abstract class AbstractEnum implements
    EnumInterface
{
    /** @var string|int */
    private $value;

    /**
     * @param string|int $value
     *
     * @throws ValueInvalidForEnumException
     */
    public function __construct($value)
    {
        if (static::has($value) === false) {
            throw ValueInvalidForEnumException::create(static::class, $value, static::all(true));
        }

        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    final public function is(EnumInterface $value): bool
    {
        if (!($value instanceof $this)) {
            return false;
        }

        return $this->value === $value->value();
    }

    /**
     * {@inheritdoc}
     */
    final public function isValue($value): bool
    {
        return $this->value === $value;
    }

    /**
     * {@inheritdoc}
     */
    public function in(array $values): bool
    {
        if ($values === []) {
            return false;
        }

        ArrayTypeAssert::assertClassArray($values, static::class, '$values');

        foreach ($values as $value) {
            if ($this->is($value) === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function inValues(array $values): bool
    {
        return in_array($this->value, $values, true);
    }

    /**
     * {@inheritdoc}
     */
    final public function toString(): string
    {
        $name = (new ReflectionObject($this))->getShortName();

        return sprintf('enum(%s:%s)', $name, $this->value);
    }
}
