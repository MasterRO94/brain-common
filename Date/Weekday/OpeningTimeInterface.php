<?php

declare(strict_types=1);

namespace Brain\Common\Date\Weekday;

use Brain\Common\Date\Enum\WeekdayEnum;
use Brain\Common\Date\Time\Time;
use Brain\Common\Date\Time\TimeRange;

/**
 * An opening time.
 */
interface OpeningTimeInterface
{
    /**
     * Return the weekday.
     */
    public function getWeekday(): WeekdayEnum;

    /**
     * Return the time opening range.
     */
    public function getTimeRange(): TimeRange;

    /**
     * Check if open on weekday.
     */
    public function isWeekdayOpen(WeekdayEnum $weekday): bool;

    /**
     * Check if open at the given time.
     */
    public function isTimeOpen(Time $time): bool;
}
