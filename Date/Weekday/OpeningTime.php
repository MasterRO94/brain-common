<?php

declare(strict_types=1);

namespace Brain\Common\Date\Weekday;

use Brain\Common\Date\Enum\WeekdayEnum;
use Brain\Common\Date\Time\Time;
use Brain\Common\Date\Time\TimeRange;
use Brain\Common\Representation\Type\StringRepresentationInterface;

/**
 * Represents an opening time period on a given weekday.
 */
final class OpeningTime implements
    OpeningTimeInterface,
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
     * {@inheritdoc}
     */
    public function getWeekday(): WeekdayEnum
    {
        return $this->weekday;
    }

    /**
     * {@inheritdoc}
     */
    public function getTimeRange(): TimeRange
    {
        return $this->range;
    }

    /**
     * {@inheritdoc}
     */
    public function isWeekdayOpen(WeekdayEnum $weekday): bool
    {
        return $this->weekday->is($weekday);
    }

    /**
     * {@inheritdoc}
     */
    public function isTimeOpen(Time $time): bool
    {
        return $this->range->isWithin($time, true);
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
