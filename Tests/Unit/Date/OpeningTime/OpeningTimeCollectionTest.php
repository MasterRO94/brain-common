<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Date\OpeningTime;

use Brain\Common\Date\Enum\WeekdayEnum;
use Brain\Common\Date\Exception\Time\TimeInvalidHourException;
use Brain\Common\Date\Exception\Time\TimeInvalidMinuteException;
use Brain\Common\Date\Exception\Time\TimeInvalidSecondException;
use Brain\Common\Date\Exception\Time\TimeRangeInvalidException;
use Brain\Common\Date\OpeningTime\OpeningTime;
use Brain\Common\Date\OpeningTime\OpeningTimeCollection;
use Brain\Common\Date\Time\Time;
use Brain\Common\Date\Time\TimeRange;
use Brain\Common\Enum\Exception\ValueInvalidForEnumException;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 * @group date
 *
 * @covers \Brain\Common\Date\OpeningTime\OpeningTimeCollection
 */
final class OpeningTimeCollectionTest extends TestCase
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
    public function canCreateOpeningTimeCollection(): void
    {
        $monday =  new OpeningTime(
            new WeekdayEnum(WeekdayEnum::DAY_MONDAY),
            new TimeRange(
                new Time(10, 0, 0),
                new Time(15, 0, 0)
            )
        );

        $tuesday =  new OpeningTime(
            new WeekdayEnum(WeekdayEnum::DAY_TUESDAY),
            new TimeRange(
                new Time(10, 0, 0),
                new Time(15, 0, 0)
            )
        );

        $collection = new OpeningTimeCollection([$monday, $tuesday]);

        self::assertEquals(2, $collection->count());
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
        $monday =  new OpeningTime(
            new WeekdayEnum(WeekdayEnum::DAY_MONDAY),
            new TimeRange(
                new Time(10, 0, 0),
                new Time(15, 0, 0)
            )
        );

        $tuesday =  new OpeningTime(
            new WeekdayEnum(WeekdayEnum::DAY_TUESDAY),
            new TimeRange(
                new Time(10, 0, 0),
                new Time(15, 0, 0)
            )
        );

        $collection = new OpeningTimeCollection([$monday, $tuesday]);

        self::assertTrue($collection->isWeekdayOpen(new WeekdayEnum(WeekdayEnum::DAY_MONDAY)));
        self::assertFalse($collection->isWeekdayOpen(new WeekdayEnum(WeekdayEnum::DAY_FRIDAY)));
    }
}
