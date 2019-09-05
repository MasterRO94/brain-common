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
     *
     * @throws PercentageBoundExceededException
     */
    public static function create(float $value): self
    {
        return new self($value);
    }

    /**
     * Create an instance from an integer between 0 and 100.
     *
     * @return Percentage
     *
     * @throws PercentageBoundExceededException
     */
    public static function createFromInteger(int $integer): self
    {
        $value = (float) $integer;

        return new self($value);
    }

    /**
     * @throws PercentageBoundExceededException
     */
    protected function __construct(float $value)
    {
        if ($value < 0 || $value > 100) {
            throw PercentageBoundExceededException::create($value);
        }

        $this->value = $value;
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
