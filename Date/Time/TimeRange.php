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
     * The inclusive flag will change the constraints of the check to be inclusive of the boundaries.
     * This means that if the value is equal to the boundaries then its considered within.
     * To have a check where the value must be within but not equal set inclusive to false.
     */
    public function isWithin(Time $time, bool $inclusive): bool
    {
        if ($inclusive === true) {
            return $this->isWithinInclusive($time);
        }

        return $this->isWithinExclusive($time);
    }

    /**
     * Check the time range given is within this time range.
     *
     * The inclusive flag will change the constraints of the check to be inclusive of the boundaries.
     * This means that if the value is equal to the boundaries then its considered within.
     */
    public function isRangeWithin(TimeRange $range, bool $inclusive): bool
    {
        if ($inclusive === true) {
            return $this->isRangeWithinInclusive($range);
        }

        return $this->isRangeWithinExclusive($range);
    }

    /**
     * Check the time range is overlapping the given range.
     *
     * The inclusive flag will change the constraints of the check to be inclusive of the boundaries.
     * This means that if the ranges sit on the same boundary (on either side) its considered overlapping.
     *
     * @example 10:00-11:00 vs 11:00-12:00 with inclusive will return true.
     */
    public function isOverlapping(TimeRange $range, bool $inclusive): bool
    {
        if ($inclusive === true) {
            return $this->isOverlappingInclusive($range);
        }

        return $this->isOverlappingExclusive($range);
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

    /**
     * Check the time is within this range or equal to the boundaries.
     */
    private function isWithinInclusive(Time $time): bool
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
     * Check the time is within this range without being equal to the boundaries.
     */
    private function isWithinExclusive(Time $time): bool
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
     * Check the given time range is within this time range inclusive boundaries.
     */
    private function isRangeWithinInclusive(TimeRange $range): bool
    {
        if ($this->lower->isGreaterThan($range->getLower())) {
            return false;
        }

        if ($this->higher->isLessThan($range->getHigher())) {
            return false;
        }

        return true;
    }

    /**
     * Check the given time range is within this time range excluding boundaries.
     */
    private function isRangeWithinExclusive(TimeRange $range): bool
    {
        if ($this->lower->isGreaterThanOrEqual($range->getLower())) {
            return false;
        }

        if ($this->higher->isLessThanOrEqual($range->getHigher())) {
            return false;
        }

        return true;
    }

    /**
     * Check the given time range is overlapping this time range or sitting on the boundaries.
     */
    private function isOverlappingInclusive(TimeRange $range): bool
    {
        if ($this->isRangeWithin($range, true)) {
            return true;
        }

        // Given range is outside the lower boundary.
        if ($this->lower->isGreaterThan($range->getHigher())) {
            return false;
        }

        // Given range is outside the higher boundary.
        if ($this->higher->isLessThan($range->getLower())) {
            return false;
        }

        return true;
    }

    /**
     * Check the given time range is overlapping this time range without sitting on the boundaries.
     */
    private function isOverlappingExclusive(TimeRange $range): bool
    {
        if ($this->isRangeWithin($range, false)) {
            return true;
        }

        // Given range is outside the lower boundary.
        if ($this->lower->isGreaterThanOrEqual($range->getHigher())) {
            return false;
        }

        // Given range is outside the higher boundary.
        if ($this->higher->isLessThanOrEqual($range->getLower())) {
            return false;
        }

        return true;
    }
}
