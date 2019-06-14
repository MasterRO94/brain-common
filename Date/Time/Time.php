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
final class Time implements
    TimeInterface
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
     * {@inheritdoc}
     */
    public function getHour(): int
    {
        return $this->hour;
    }

    /**
     * {@inheritdoc}
     */
    public function getMinute(): int
    {
        return $this->minute;
    }

    /**
     * {@inheritdoc}
     */
    public function getSecond(): int
    {
        return $this->second;
    }

    /**
     * {@inheritdoc}
     */
    public function isGreaterThanOrEqual(TimeInterface $time): bool
    {
        return $this->isEqual($time)
            || $this->isGreaterThan($time);
    }

    /**
     * {@inheritdoc}
     */
    public function isEqual(TimeInterface $time): bool
    {
        return $this->toInteger() === $time->toInteger();
    }

    /**
     * {@inheritdoc}
     */
    public function isGreaterThan(TimeInterface $time): bool
    {
        return $this->toInteger() > $time->toInteger();
    }

    /**
     * {@inheritdoc}
     */
    public function isLessThanOrEqual(TimeInterface $time): bool
    {
        return $this->isEqual($time)
            || $this->isLessThan($time);
    }

    /**
     * {@inheritdoc}
     */
    public function isLessThan(TimeInterface $time): bool
    {
        return $this->toInteger() < $time->toInteger();
    }

    /**
     * {@inheritdoc}
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

    /**
     * {@inheritdoc}
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
}
