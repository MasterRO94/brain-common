<?php

declare(strict_types=1);

namespace Brain\Common\Date\Assert;

use Brain\Common\Date\Exception\Time\TimeInvalidHourException;
use Brain\Common\Date\Exception\Time\TimeInvalidMinuteException;
use Brain\Common\Date\Exception\Time\TimeInvalidSecondException;

final class TimeAssert
{
    public const TIME_HOUR_MINIMUM = 0;
    public const TIME_HOUR_MAXIMUM = 23;

    public const TIME_MINUTE_MINIMUM = 0;
    public const TIME_MINUTE_MAXIMUM = 59;

    public const TIME_SECOND_MINIMUM = 0;
    public const TIME_SECOND_MAXIMUM = 59;

    /**
     * Validate the given hour.
     *
     * @throws TimeInvalidHourException
     */
    public static function assertHourValid(int $hour): void
    {
        if ($hour < self::TIME_HOUR_MINIMUM) {
            throw TimeInvalidHourException::create($hour);
        }

        if ($hour > self::TIME_HOUR_MAXIMUM) {
            throw TimeInvalidHourException::create($hour);
        }
    }

    /**
     * Validate the given minute.
     *
     * @throws TimeInvalidMinuteException
     */
    public static function assertMinuteValid(int $minute): void
    {
        if ($minute < self::TIME_MINUTE_MINIMUM) {
            throw TimeInvalidMinuteException::create($minute);
        }

        if ($minute > self::TIME_MINUTE_MAXIMUM) {
            throw TimeInvalidMinuteException::create($minute);
        }
    }

    /**
     * Validate the given second.
     *
     * @throws TimeInvalidSecondException
     */
    public static function assertSecondValid(int $second): void
    {
        if ($second < self::TIME_SECOND_MINIMUM) {
            throw TimeInvalidSecondException::create($second);
        }

        if ($second > self::TIME_SECOND_MAXIMUM) {
            throw TimeInvalidSecondException::create($second);
        }
    }
}
