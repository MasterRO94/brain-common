<?php

declare(strict_types=1);

namespace Brain\Common\Date\Time;

use Brain\Common\Date\Exception\Time\TimeRangeInvalidException;

/**
 * A time range.
 */
final class TimeRange
{
    /** @var Time */
    private $lower;

    /** @var Time */
    private $higher;

    /**
     * @throws TimeRangeInvalidException
     */
    public function __construct(Time $lower, Time $higher)
    {
        if ($lower->isGreaterThan($higher)) {
            throw TimeRangeInvalidException::create($lower, $higher);
        }

        $this->lower = $lower;
        $this->higher = $higher;
    }

    /**
     * Return the lower boundary.
     */
    public function getLower(): Time
    {
        return $this->lower;
    }

    /**
     * Return the higher boundary.
     */
    public function getHigher(): Time
    {
        return $this->higher;
    }

    /**
     * Check the time is within this time range.
     *
     * This check will essentially do greater/less than or equal on the boundaries.
     * This means that the value can equal the boundary values.
     */
    public function isWithin(Time $time): bool
    {
        if ($this->lower->isGreaterThan($time)) {
            return false;
        }

        if ($this->higher->isLessThan($time)) {
            return false;
        }

        return true;
    }

    /**
     * Check the time is within this time range without being equal to the boundaries.
     */
    public function isWithinExclusive(Time $time): bool
    {
        if ($this->lower->isGreaterThanOrEqual($time)) {
            return false;
        }

        if ($this->higher->isLessThanOrEqual($time)) {
            return false;
        }

        return true;
    }

    /**
     * Return this object in string representation.
     */
    public function toString(): string
    {
        return sprintf(
            '%s-%s',
            $this->lower->toString(),
            $this->higher->toString()
        );
    }
}
