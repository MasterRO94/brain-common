<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Date\Time;

use Brain\Common\Date\Exception\Time\TimeInvalidHourException;
use Brain\Common\Date\Exception\Time\TimeInvalidMinuteException;
use Brain\Common\Date\Exception\Time\TimeInvalidSecondException;
use Brain\Common\Date\Exception\Time\TimeInvalidStringFormatException;
use Brain\Common\Date\Exception\Time\TimeRangeInvalidException;
use Brain\Common\Date\Time\Time;
use Brain\Common\Date\Time\TimeRange;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 * @group date
 *
 * @covers \Brain\Common\Date\Time\TimeRange
 */
final class TimeRangeTest extends TestCase
{
    /**
     * @test
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     * @throws TimeRangeInvalidException
     */
    public function withRangeOrderInvalidThrow(): void
    {
        $lower = new Time(10, 11, 12);
        $higher = new Time(20, 21, 22);

        self::expectException(TimeRangeInvalidException::class);
        self::expectExceptionMessage('A time range cannot be constructed with lower "20:21:22" and higher "10:11:12". The lower time should not be greater than the higher time.');

        new TimeRange($higher, $lower);
    }

    /**
     * @test
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     * @throws TimeRangeInvalidException
     */
    public function canConstructTimeRange(): void
    {
        $lower = new Time(10, 11, 12);
        $higher = new Time(20, 21, 22);

        $range = new TimeRange($lower, $higher);

        self::assertSame($lower, $range->getLower());
        self::assertSame($higher, $range->getHigher());
    }

    /**
     * @test
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     * @throws TimeRangeInvalidException
     */
    public function canConvertTimeRangeToString(): void
    {
        $lower = new Time(10, 11, 12);
        $higher = new Time(20, 21, 22);

        $range = new TimeRange($lower, $higher);

        self::assertEquals('10:11:12-20:21:22', $range->toString());
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanCheckTimeWithinTimeRange(): array
    {
        // First value is lower, second is higher, third is comparison.
        return [
            'zero' => [true, '00:00:00', '00:00:00', '00:00:00'],

            'on-lower-bound' => [true, '00:00:00', '00:00:10', '00:00:00'],
            'on-higher-bound' => [true, '00:00:00', '00:00:10', '00:00:10'],

            'below-lower-bound' => [false, '00:00:10', '00:00:20', '00:00:09'],
            'above-higher-bound' => [false, '00:00:10', '00:00:20', '00:00:21'],

            'second-within-safe' => [true, '00:00:10', '00:00:20', '00:00:15'],
            'second-within-lower-edge' => [true, '00:00:10', '00:00:20', '00:00:11'],
            'second-within-higher-edge' => [true, '00:00:10', '00:00:20', '00:00:19'],

            'minute-within-safe' => [true, '00:10:00', '00:20:00', '00:15:00'],
            'minute-within-lower-edge' => [true, '00:10:00', '00:20:00', '00:11:00'],
            'minute-within-higher-edge' => [true, '00:10:00', '00:20:00', '00:19:00'],

            'hour-within-safe' => [true, '10:00:00', '20:00:00', '15:00:00'],
            'hour-within-lower-edge' => [true, '10:00:00', '20:00:00', '11:00:00'],
            'hour-within-higher-edge' => [true, '10:00:00', '20:00:00', '19:00:00'],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanCheckTimeWithinTimeRange
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     * @throws TimeInvalidStringFormatException
     * @throws TimeRangeInvalidException
     */
    public function canCheckTimeWithinTimeRange(bool $expected, string $lower, string $higher, string $comparison): void
    {
        $a = Time::createFromStringFull($lower);
        $b = Time::createFromStringFull($higher);
        $c = Time::createFromStringFull($comparison);

        $range = new TimeRange($a, $b);

        $response = $range->isWithin($c);

        self::assertEquals($expected, $response);
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanCheckTimeWithinExclusiveTimeRange(): array
    {
        // First value is lower, second is higher, third is comparison.
        return [
            'zero' => [false, '00:00:00', '00:00:00', '00:00:00'],

            'on-lower-bound' => [false, '00:00:00', '00:00:10', '00:00:00'],
            'on-higher-bound' => [false, '00:00:00', '00:00:10', '00:00:10'],

            'below-lower-bound' => [false, '00:00:10', '00:00:20', '00:00:09'],
            'above-higher-bound' => [false, '00:00:10', '00:00:20', '00:00:21'],

            'second-within-safe' => [true, '00:00:10', '00:00:20', '00:00:15'],
            'second-within-lower-edge' => [true, '00:00:10', '00:00:20', '00:00:11'],
            'second-within-higher-edge' => [true, '00:00:10', '00:00:20', '00:00:19'],

            'minute-within-safe' => [true, '00:10:00', '00:20:00', '00:15:00'],
            'minute-within-lower-edge' => [true, '00:10:00', '00:20:00', '00:11:00'],
            'minute-within-higher-edge' => [true, '00:10:00', '00:20:00', '00:19:00'],

            'hour-within-safe' => [true, '10:00:00', '20:00:00', '15:00:00'],
            'hour-within-lower-edge' => [true, '10:00:00', '20:00:00', '11:00:00'],
            'hour-within-higher-edge' => [true, '10:00:00', '20:00:00', '19:00:00'],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanCheckTimeWithinExclusiveTimeRange
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     * @throws TimeInvalidStringFormatException
     * @throws TimeRangeInvalidException
     */
    public function canCheckTimeWithinExclusiveTimeRange(bool $expected, string $lower, string $higher, string $comparison): void
    {
        $a = Time::createFromStringFull($lower);
        $b = Time::createFromStringFull($higher);
        $c = Time::createFromStringFull($comparison);

        $range = new TimeRange($a, $b);

        $response = $range->isWithinExclusive($c);

        self::assertEquals($expected, $response);
    }
}
