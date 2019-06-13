<?php

declare(strict_types=1);

namespace Brain\Common\Date\Time;

use Brain\Common\Date\Assert\TimeAssert;
use Brain\Common\Date\Exception\Time\TimeInvalidHourException;
use Brain\Common\Date\Exception\Time\TimeInvalidMinuteException;
use Brain\Common\Date\Exception\Time\TimeInvalidSecondException;
use Brain\Common\Date\Exception\Time\TimeInvalidStringFormatException;
use Brain\Common\Regex\RegexMatch;

use DateTimeInterface;

/**
 * An instance of time.
 */
final class Time
{
    private const TIME_STRING_REGEX_FULL = '/[0-2]\d:[0-5]\d:[0-5]\d/';
    private const TIME_STRING_REGEX_SHORT = '/[0-2]\d:[0-5]\d/';

    /** @var int */
    private $hour;

    /** @var int */
    private $minute;

    /** @var int */
    private $second;

    /**
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     */
    public function __construct(int $hour, int $minute, int $second)
    {
        TimeAssert::assertHourValid($hour);
        TimeAssert::assertMinuteValid($minute);
        TimeAssert::assertSecondValid($second);

        $this->hour = $hour;
        $this->minute = $minute;
        $this->second = $second;
    }

    /**
     * Create an instance from a full time string.
     *
     * This string should include all elements of time and be in HH:MM:SS format.
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     * @throws TimeInvalidStringFormatException
     */
    public static function createFromStringFull(string $time): self
    {
        if (RegexMatch::match(self::TIME_STRING_REGEX_FULL, $time) === false) {
            throw TimeInvalidStringFormatException::create($time, 'HH:MM:SS');
        }

        [$hour, $minute, $second] = explode(':', $time);

        $hour = (int) $hour;
        $minute = (int) $minute;
        $second = (int) $second;

        return new self($hour, $minute, $second);
    }

    /**
     * Create an instance from a short time string.
     *
     * This string should include only hours and minutes and be in HH:MM format.
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     * @throws TimeInvalidStringFormatException
     */
    public static function createFromStringShort(string $time): self
    {
        if (RegexMatch::match(self::TIME_STRING_REGEX_SHORT, $time) === false) {
            throw TimeInvalidStringFormatException::create($time, 'HH:MM');
        }

        [$hour, $minute] = explode(':', $time);

        $hour = (int) $hour;
        $minute = (int) $minute;

        return new self($hour, $minute, 0);
    }

    /**
     * Create an instance from a date time.
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     */
    public static function createFromDateTimeInterface(DateTimeInterface $date): self
    {
        $hour = (int) $date->format('H');
        $minute = (int) $date->format('i');
        $second = (int) $date->format('s');

        return new self($hour, $minute, $second);
    }

    /**
     * Return the hour.
     */
    public function getHour(): int
    {
        return $this->hour;
    }

    /**
     * Return the minute.
     */
    public function getMinute(): int
    {
        return $this->minute;
    }

    /**
     * Return the second.
     */
    public function getSecond(): int
    {
        return $this->second;
    }

    /**
     * Check if this instance if greater than or equal to the given time.
     */
    public function isGreaterThanOrEqual(Time $time): bool
    {
        return $this->isEqual($time)
            || $this->isGreaterThan($time);
    }

    /**
     * Check if this instance is equal to the given time.
     */
    public function isEqual(Time $time): bool
    {
        return $this->toInteger() === $time->toInteger();
    }

    /**
     * Return this object as an integer.
     *
     * The representation for a time as integer is a timestamp.
     * The value should be the valid amount of seconds this time consists of.
     * There are 86400 seconds in a day, but this number is zero based so 86399 is the highest value.
     */
    public function toInteger(): int
    {
        // Using the beginning of the epoch as the date, then we should be able to get seconds from that.
        return gmmktime($this->hour, $this->minute, $this->second, 1, 1, 1970);
    }

    /**
     * Check if this instance is greater than the given time.
     */
    public function isGreaterThan(Time $time): bool
    {
        return $this->toInteger() > $time->toInteger();
    }

    /**
     * Check if this instance if less than or equal to the given time.
     */
    public function isLessThanOrEqual(Time $time): bool
    {
        return $this->isEqual($time)
            || $this->isLessThan($time);
    }

    /**
     * Check if this instance is less than the given time.
     */
    public function isLessThan(Time $time): bool
    {
        return $this->toInteger() < $time->toInteger();
    }

    /**
     * Return this object in string representation.
     */
    public function toString(): string
    {
        return sprintf(
            '%02d:%02d:%02d',
            $this->hour,
            $this->minute,
            $this->second
        );
    }
}
