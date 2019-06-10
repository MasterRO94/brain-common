<?php

namespace Brain\Common\Date\Enum;

use Brain\Common\Enum\AbstractEnum;

/**
 * Days of the week.
 */
final class WeekDayEnum extends AbstractEnum
{
    const DAY_SUNDAY = 0;
    const DAY_MONDAY = 1;
    const DAY_TUESDAY = 2;
    const DAY_WEDNESDAY = 3;
    const DAY_THURSDAY = 4;
    const DAY_FRIDAY = 5;
    const DAY_SATURDAY = 6;

    /**
     * {@inheritdoc}
     */
    protected static function getTranslationPrefix(): string
    {
        return 'day';
    }

    /**
     * {@inheritdoc}
     */
    protected static function getValues(): array
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
}
