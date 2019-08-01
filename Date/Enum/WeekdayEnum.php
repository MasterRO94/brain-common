<?php

declare(strict_types=1);

namespace Brain\Common\Date\Enum;

use Brain\Common\Enum\Exception\ValueInvalidForEnumException;
use Brain\Common\Enum\Type\Implementation\AbstractIntegerTranslationEnum;
use Brain\Common\Exception\Developer\DeveloperContractRuntimeException;

use DateTimeInterface;

/**
 * Enum of weekdays.
 */
final class WeekdayEnum extends AbstractIntegerTranslationEnum
{
    public const DAY_SUNDAY = 0;
    public const DAY_MONDAY = 1;
    public const DAY_TUESDAY = 2;
    public const DAY_WEDNESDAY = 3;
    public const DAY_THURSDAY = 4;
    public const DAY_FRIDAY = 5;
    public const DAY_SATURDAY = 6;

    /**
     * Create a weekday instance from the given date time interface.
     */
    public static function createFromDateTimeInterface(DateTimeInterface $date): WeekdayEnum
    {
        $weekday = (int) $date->format('w');

        try {
            $weekday = new self($weekday);
        } catch (ValueInvalidForEnumException $exception) {
            // It is technically impossible for the date time to return an invalid weekday.
            // However to prevent the exception being considered by static analysis we wrap it.
            throw DeveloperContractRuntimeException::create($exception);
        }

        return $weekday;
    }

    /**
     * {@inheritdoc}
     */
    protected static function values(): array
    {
        return [
            self::DAY_SUNDAY,
            self::DAY_MONDAY,
            self::DAY_TUESDAY,
            self::DAY_WEDNESDAY,
            self::DAY_THURSDAY,
            self::DAY_FRIDAY,
            self::DAY_SATURDAY,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected static function prefix(): string
    {
        return 'weekday';
    }

    /**
     * {@inheritdoc}
     */
    protected static function translations(): array
    {
        return [
            self::DAY_SUNDAY => 'sunday',
            self::DAY_MONDAY => 'monday',
            self::DAY_TUESDAY => 'tuesday',
            self::DAY_WEDNESDAY => 'wednesday',
            self::DAY_THURSDAY => 'thursday',
            self::DAY_FRIDAY => 'friday',
            self::DAY_SATURDAY => 'saturday',
        ];
    }
}
