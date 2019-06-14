<?php

declare(strict_types=1);

namespace Brain\Common\Date\Weekday;

use Brain\Common\Date\Assert\WeekdayAssert;
use Brain\Common\Date\Enum\WeekdayEnum;
use Brain\Common\Date\Exception\Weekday\WeekdayInvalidException;
use Brain\Common\Date\Time\TimeRange;
use Brain\Common\Representation\Type\StringRepresentationInterface;

/**
 * Represents an opening time period on a given weekday.
 */
final class OpeningTime implements
    StringRepresentationInterface
{
    /** @var WeekdayEnum */
    private $weekday;

    /** @var TimeRange */
    private $range;

    public function __construct(WeekdayEnum $weekday, TimeRange $range)
    {
        $this->weekday = $weekday;
        $this->range = $range;
    }

    /**
     * Return the weekday.
     */
    public function getWeekday(): WeekdayEnum
    {
        return $this->weekday;
    }

    /**
     * Return the time opening range.
     */
    public function getTimeRange(): TimeRange
    {
        return $this->range;
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return sprintf(
            '%s(%s)',
            $this->weekday->translation(false),
            $this->range->toString()
        );
    }
}
