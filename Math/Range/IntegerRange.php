<?php

declare(strict_types=1);

namespace Brain\Common\Math\Range;

use Brain\Common\Math\Exception\Range\IntegerRangeNotPositiveException;
use Brain\Common\Representation\StringMagicRepresentationTrait;
use Brain\Common\Representation\Type\ArrayRepresentationInterface;
use Brain\Common\Representation\Type\StringRepresentationInterface;

/**
 * An integer range.
 */
final class IntegerRange implements
    StringRepresentationInterface,
    ArrayRepresentationInterface
{
    use StringMagicRepresentationTrait;

    /** @var int */
    private $start;

    /** @var int */
    private $finish;

    /**
     * Create an unrestricted range.
     *
     * @return IntegerRange
     */
    public static function create(int $start, int $finish): self
    {
        return new self($start, $finish);
    }

    /**
     * Create a positive range where the finish bound can only be equal or greater than the start.
     *
     * @return IntegerRange
     *
     * @throws IntegerRangeNotPositiveException
     */
    public static function createForwardRange(int $start, int $finish): self
    {
        $range = new self($start, $finish);

        if ($range->isRange() === false) {
            return $range;
        }

        if ($range->isForward() === false) {
            throw IntegerRangeNotPositiveException::create($start, $finish);
        }

        return $range;
    }

    /**
     * Create a range from a data array.
     *
     * This expects the same input as the array representation.
     * That being an array with two values, the start and finish as integer.
     *
     * @param int[] $data
     *
     * @return IntegerRange
     */
    public static function createFromArray(array $data): self
    {
        return self::create($data[0], $data[1]);
    }

    protected function __construct(int $start, int $finish)
    {
        $this->start = $start;
        $this->finish = $finish;
    }

    /**
     * Return the start bound.
     */
    public function start(): int
    {
        return $this->start;
    }

    /**
     * Return the finish bound.
     */
    public function finish(): int
    {
        return $this->finish;
    }

    /**
     * Check if the values have distance between.
     */
    public function isRange(): bool
    {
        return $this->start !== $this->finish;
    }

    /**
     * Check the range is in positive numbers.
     */
    public function isNatural(): bool
    {
        if ($this->start <= 0) {
            return false;
        }

        if ($this->finish <= 0) {
            return false;
        }

        return true;
    }

    /**
     * Check if the range is forward in direction.
     *
     * This means the start value is before the finish value.
     * When the range is not really a range (both values match) this returns false.
     */
    public function isForward(): bool
    {
        if ($this->isRange() === false) {
            return false;
        }

        return $this->start < $this->finish;
    }

    /**
     * Check if the range is backward in direction.
     *
     * This means the start value is after the finish value.
     * When the range is not really a range (both values match) this returns false.
     */
    public function isBackward(): bool
    {
        if ($this->isRange() === false) {
            return false;
        }

        return $this->start > $this->finish;
    }

    /**
     * Return the distance between start and finish.
     */
    public function distance(): int
    {
        if ($this->isRange() === false) {
            return 0;
        }

        return abs($this->start - $this->finish);
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return sprintf(
            '%d:%d',
            $this->start,
            $this->finish
        );
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            $this->start,
            $this->finish,
        ];
    }
}
