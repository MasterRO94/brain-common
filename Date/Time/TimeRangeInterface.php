<?php

namespace Brain\Common\Date\Time;

/**
 * A range of time.
 */
interface TimeRangeInterface
{
    /**
     * Return the lower boundary.
     */
    public function getLower(): TimeInterface;

    /**
     * Return the higher boundary.
     */
    public function getHigher(): TimeInterface;

    /**
     * Check the time is within this time range.
     *
     * The inclusive flag will change the constraints of the check to be inclusive of the boundaries.
     * This means that if the value is equal to the boundaries then its considered within.
     * To have a check where the value must be within but not equal set inclusive to false.
     */
    public function isWithin(TimeInterface $time, bool $inclusive): bool;

    /**
     * Check the time range given is within this time range.
     *
     * The inclusive flag will change the constraints of the check to be inclusive of the boundaries.
     * This means that if the value is equal to the boundaries then its considered within.
     */
    public function isRangeWithin(TimeRangeInterface $range, bool $inclusive): bool;

    /**
     * Check the time range is overlapping the given range.
     *
     * The inclusive flag will change the constraints of the check to be inclusive of the boundaries.
     * This means that if the ranges sit on the same boundary (on either side) its considered overlapping.
     *
     * @example 10:00-11:00 vs 11:00-12:00 with inclusive will return true.
     */
    public function isOverlapping(TimeRangeInterface $range, bool $inclusive): bool;
}
