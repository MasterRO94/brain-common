<?php

declare(strict_types=1);

namespace Brain\Common\Spacial;

use Brain\Common\Dimension\TwoDimensionalInterface;

/**
 * A representation of area.
 */
final class Area implements AreaInterface
{
    /** @var int */
    private $value;

    /**
     * Create a zero area instance.
     *
     * @return Area
     */
    public static function createZero(): self
    {
        return new self(0);
    }

    /**
     * Create an area from two dimensional.
     *
     * @return Area
     */
    public static function createFromTwoDimensional(TwoDimensionalInterface $dimensional): self
    {
        return new self($dimensional->getWidth() * $dimensional->getHeight());
    }

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function isEqual(AreaInterface $area): bool
    {
        return $this->value === $area->toInteger();
    }

    /**
     * {@inheritdoc}
     */
    public function isLessThan(AreaInterface $area): bool
    {
        return $this->value < $area->toInteger();
    }

    /**
     * {@inheritdoc}
     */
    public function isLessThanOrEqual(AreaInterface $area): bool
    {
        return $this->value <= $area->toInteger();
    }

    /**
     * {@inheritdoc}
     */
    public function isGreaterThan(AreaInterface $area): bool
    {
        return $this->value > $area->toInteger();
    }

    /**
     * {@inheritdoc}
     */
    public function isGreaterThanOrEqual(AreaInterface $area): bool
    {
        return $this->value >= $area->toInteger();
    }

    /**
     * {@inheritdoc}
     */
    public function isWithin(AreaInterface $lower, AreaInterface $upper): bool
    {
        if ($this->isLessThan($lower) === true) {
            return false;
        }

        if ($this->isGreaterThan($upper) === true) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function toInteger(): int
    {
        return $this->value;
    }
}
