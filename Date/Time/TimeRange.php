<?php

declare(strict_types=1);

namespace Brain\Common\Date\Time;

use Brain\Common\Date\Exception\Time\TimeRangeInvalidException;
use Brain\Common\Representation\Type\StringRepresentationInterface;

/**
 * A time range.
 */
final class TimeRange implements
    TimeRangeInterface
{
    /** @var TimeInterface */
    private $lower;

    /** @var TimeInterface */
    private $higher;

    /**
     * @throws TimeRangeInvalidException
     */
    public function __construct(TimeInterface $lower, TimeInterface $higher)
    {
        if ($lower->isGreaterThan($higher)) {
            throw TimeRangeInvalidException::create($lower, $higher);
        }

        $this->lower = $lower;
        $this->higher = $higher;
    }

    /**
     * {@inheritdoc}
     */
    public function getLower(): TimeInterface
    {
        return $this->lower;
    }

    /**
     * {@inheritdoc}
     */
    public function getHigher(): TimeInterface
    {
        return $this->higher;
    }

    /**
     * {@inheritdoc}
     */
    public function isWithin(TimeInterface $time, bool $inclusive): bool
    {
        if ($inclusive === true) {
            return $this->isWithinInclusive($time);
        }

        return $this->isWithinExclusive($time);
    }

    /**
     * {@inheritdoc}
     */
    public function isRangeWithin(TimeRangeInterface $range, bool $inclusive): bool
    {
        if ($inclusive === true) {
            return $this->isRangeWithinInclusive($range);
        }

        return $this->isRangeWithinExclusive($range);
    }

    /**
     * {@inheritdoc}
     */
    public function isOverlapping(TimeRangeInterface $range, bool $inclusive): bool
    {
        if ($inclusive === true) {
            return $this->isOverlappingInclusive($range);
        }

        return $this->isOverlappingExclusive($range);
    }

    /**
     * {@inheritdoc}
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
    private function isWithinInclusive(TimeInterface $time): bool
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
    private function isWithinExclusive(TimeInterface $time): bool
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
    private function isRangeWithinInclusive(TimeRangeInterface $range): bool
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
    private function isRangeWithinExclusive(TimeRangeInterface $range): bool
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
    private function isOverlappingInclusive(TimeRangeInterface $range): bool
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
    private function isOverlappingExclusive(TimeRangeInterface $range): bool
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
