<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Date\OpeningTime;

use Brain\Common\Date\Enum\WeekdayEnum;
use Brain\Common\Date\Exception\Time\TimeInvalidHourException;
use Brain\Common\Date\Exception\Time\TimeInvalidMinuteException;
use Brain\Common\Date\Exception\Time\TimeInvalidSecondException;
use Brain\Common\Date\Exception\Time\TimeRangeInvalidException;
use Brain\Common\Date\OpeningTime\OpeningTime;
use Brain\Common\Date\Time\Time;
use Brain\Common\Date\Time\TimeRange;
use Brain\Common\Enum\Exception\ValueInvalidForEnumException;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 * @group date
 *
 * @covers \Brain\Common\Date\OpeningTime\OpeningTime
 */
final class OpeningTimeTest extends TestCase
{
    /**
     * @test
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     * @throws TimeRangeInvalidException
     * @throws ValueInvalidForEnumException
     */
    public function canGetComponents(): void
    {
        $weekday = new WeekdayEnum(WeekdayEnum::DAY_TUESDAY);

        $range = new TimeRange(
            new Time(10, 0, 0),
            new Time(15, 0, 0)
        );

        $opening = new OpeningTime($weekday, $range);

        self::assertSame($weekday, $opening->getWeekday());
        self::assertSame($range, $opening->getTimeRange());
    }

    /**
     * @test
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     * @throws TimeRangeInvalidException
     * @throws ValueInvalidForEnumException
     */
    public function canConvertOpeningTimeToString(): void
    {
        $opening = new OpeningTime(
            new WeekdayEnum(WeekdayEnum::DAY_TUESDAY),
            new TimeRange(
                new Time(10, 0, 0),
                new Time(15, 0, 0)
            )
        );

        $expected = 'tuesday(10:00:00-15:00:00)';

        self::assertEquals($expected, $opening->toString());
    }

    /**
     * @test
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     * @throws TimeRangeInvalidException
     * @throws ValueInvalidForEnumException
     */
    public function canCheckWeekdayIsOpen(): void
    {
        $opening = new OpeningTime(
            new WeekdayEnum(WeekdayEnum::DAY_TUESDAY),
            new TimeRange(
                new Time(10, 0, 0),
                new Time(15, 0, 0)
            )
        );

        self::assertTrue($opening->isWeekdayOpen(new WeekdayEnum(WeekdayEnum::DAY_TUESDAY)));
        self::assertFalse($opening->isWeekdayOpen(new WeekdayEnum(WeekdayEnum::DAY_THURSDAY)));
    }

    /**
     * @test
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     * @throws TimeRangeInvalidException
     * @throws ValueInvalidForEnumException
     */
    public function canCheckTimeIsOpen(): void
    {
        $opening = new OpeningTime(
            new WeekdayEnum(WeekdayEnum::DAY_TUESDAY),
            new TimeRange(
                new Time(10, 0, 0),
                new Time(15, 0, 0)
            )
        );

        self::assertTrue($opening->isTimeOpen(new Time(11, 0, 0)));
        self::assertFalse($opening->isTimeOpen(new Time(9, 0, 0)));
        self::assertFalse($opening->isTimeOpen(new Time(16, 0, 0)));
    }
}
