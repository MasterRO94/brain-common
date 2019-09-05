<?php

declare(strict_types=1);

namespace Brain\Common\Math\Percentage;

use Brain\Common\Math\Exception\Percentage\PercentageBoundExceededException;
use Brain\Common\Math\Rounding;
use Brain\Common\Representation\StringMagicRepresentationTrait;
use Brain\Common\Representation\Type\FloatRepresentationInterface;
use Brain\Common\Representation\Type\IntegerRepresentationInterface;
use Brain\Common\Representation\Type\StringRepresentationInterface;

/**
 * A representation of a percentage.
 *
 * Note this percentage is immutable and doing any operation on it will result in a new percentage.
 * For example rounding the percentage will not change this value.
 */
final class Percentage implements
    StringRepresentationInterface,
    IntegerRepresentationInterface,
    FloatRepresentationInterface
{
    use StringMagicRepresentationTrait;

    /** @var float */
    private $value;

    /**
     * Create an instance from a floating point number between 0 and 100.
     *
     * @return Percentage
     */
    public static function create(float $value): self
    {
        return new self($value);
    }

    /**
     * Create an instance from an integer between 0 and 100.
     *
     * @return Percentage
     */
    public static function createFromInteger(int $integer): self
    {
        $value = (float) $integer;

        return new self($value);
    }

    /**
     * Create an instance from an position in a range.
     *
     * @param int|float $position
     *
     * @return Percentage
     */
    public static function createFromRange($position, int $range): self
    {
        $value = ($position / $range) * 100;

        return new self($value);
    }

    /**
     * Create a natural percentage that should not exceed the bounds of 0 and 100.
     *
     * @return Percentage
     *
     * @throws PercentageBoundExceededException
     */
    public static function createNatural(float $value): self
    {
        if ($value < 0 || $value > 100) {
            throw PercentageBoundExceededException::create($value);
        }

        return new self($value);
    }

    protected function __construct(float $value)
    {
        $this->value = $value;
    }

    /**
     * Round the percentage.
     *
     * @return Percentage
     */
    public function round(int $precision): self
    {
        return new self(Rounding::roundTo($this->value, $precision));
    }

    /**
     * {@inheritdoc}g
     */
    public function toString(): string
    {
        return sprintf('%01.2f%%', $this->value);
    }

    /**
     * {@inheritdoc}
     */
    public function toInteger(): int
    {
        return Rounding::roundToInteger($this->value);
    }

    /**
     * {@inheritdoc}
     */
    public function toFloat(): float
    {
        return $this->value;
    }
}
