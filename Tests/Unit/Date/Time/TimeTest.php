<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Date\Time;

use Brain\Common\Date\Exception\Time\TimeInvalidHourException;
use Brain\Common\Date\Exception\Time\TimeInvalidMinuteException;
use Brain\Common\Date\Exception\Time\TimeInvalidSecondException;
use Brain\Common\Date\Exception\Time\TimeInvalidStringFormatException;
use Brain\Common\Date\Time\Time;

use Nette\Utils\DateTime;
use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 * @group date
 *
 * @covers \Brain\Common\Date\Time\Time
 * @covers \Brain\Common\Date\Exception\Time\TimeInvalidHourException
 * @covers \Brain\Common\Date\Exception\Time\TimeInvalidMinuteException
 * @covers \Brain\Common\Date\Exception\Time\TimeInvalidSecondException
 * @covers \Brain\Common\Date\Exception\Time\TimeInvalidStringFormatException
 */
final class TimeTest extends TestCase
{
    /**
     * @test
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     */
    public function withInvalidHourThrow(): void
    {
        self::expectException(TimeInvalidHourException::class);

        new Time(40, 10, 10);
    }

    /**
     * @test
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     */
    public function withInvalidMinuteThrow(): void
    {
        self::expectException(TimeInvalidMinuteException::class);

        new Time(11, 80, 10);
    }

    /**
     * @test
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     */
    public function withInvalidSecondThrow(): void
    {
        self::expectException(TimeInvalidSecondException::class);

        new Time(11, 12, 80);
    }

    /**
     * @test
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     */
    public function canConstructValidTime(): void
    {
        $time = new Time(11, 12, 13);

        self::assertEquals(11, $time->getHour());
        self::assertEquals(12, $time->getMinute());
        self::assertEquals(13, $time->getSecond());

        self::assertEquals('11:12:13', $time->toString());
    }

    /**
     * @test
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     */
    public function canConvertTimeToStringWithLeadingZero(): void
    {
        $time = new Time(1, 2, 3);

        self::assertEquals('01:02:03', $time->toString());
    }

    /**
     * @test
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     */
    public function canConvertZeroTimeToString(): void
    {
        $time = new Time(0, 0, 0);

        self::assertEquals('00:00:00', $time->toString());
    }

    /**
     * @test
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     * @throws TimeInvalidStringFormatException
     */
    public function withInvalidFullStringThrow(): void
    {
        self::expectException(TimeInvalidStringFormatException::class);
        self::expectExceptionMessage('The given value "1:30:3" is not a valid time format. Please provide a string in the format "HH:MM:SS".');

        Time::createFromStringFull('1:30:3');
    }

    /**
     * @test
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     * @throws TimeInvalidStringFormatException
     */
    public function canCreateFromFullString(): void
    {
        $time = Time::createFromStringFull('11:12:13');

        self::assertEquals(11, $time->getHour());
        self::assertEquals(12, $time->getMinute());
        self::assertEquals(13, $time->getSecond());
    }

    /**
     * @test
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     * @throws TimeInvalidStringFormatException
     */
    public function withInvalidShortStringThrow(): void
    {
        self::expectException(TimeInvalidStringFormatException::class);
        self::expectExceptionMessage('The given value "1:45:3" is not a valid time format. Please provide a string in the format "HH:MM".');

        Time::createFromStringShort('1:45:3');
    }

    /**
     * @test
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     * @throws TimeInvalidStringFormatException
     */
    public function canCreateFromShortString(): void
    {
        $time = Time::createFromStringShort('11:12');

        self::assertEquals(11, $time->getHour());
        self::assertEquals(12, $time->getMinute());
        self::assertEquals(0, $time->getSecond());
    }

    /**
     * @test
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     */
    public function canCreateFromDateTimeInterface(): void
    {
        $date = new DateTime('2019-01-01 12:13:14');

        $time = Time::createFromDateTimeInterface($date);

        self::assertEquals(12, $time->getHour());
        self::assertEquals(13, $time->getMinute());
        self::assertEquals(14, $time->getSecond());
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanConvertTimeToInteger(): array
    {
        return [
            'zero' => [0, '00:00:00'],

            'single-second' => [5, '00:00:05'],
            'double-second' => [35, '00:00:35'],

            'single-minute' => [300, '00:05:00'],
            'double-minute' => [900, '00:15:00'],

            'single-hour' => [3600, '01:00:00'],
            'double-hour' => [39600, '11:00:00'],

            'combination-1' => [3723, '01:02:03'],
            'combination-2' => [40271, '11:11:11'],

            'all' => [86399, '23:59:59'],
            'all-minus-one' => [86398, '23:59:58'],
            'all-minus-another' => [86338, '23:58:58'],
            'all-minus-again' => [82738, '22:58:58'],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanConvertTimeToInteger
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     * @throws TimeInvalidStringFormatException
     */
    public function canConvertTimeToInteger(int $expected, string $format): void
    {
        $time = Time::createFromStringFull($format);

        self::assertEquals($expected, $time->toInteger());
    }

    /**
     * @test
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     * @throws TimeInvalidStringFormatException
     */
    public function canCheckTimeEqual(): void
    {
        $a = Time::createFromStringFull('10:10:10');
        $b = Time::createFromStringFull('10:10:10');
        $c = Time::createFromStringFull('11:11:11');

        self::assertTrue($a->isEqual($b));
        self::assertFalse($a->isEqual($c));
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanCheckTimeGreaterThan(): array
    {
        // First date is the base, the second is the comparison.
        // Think of it as left side greater than right side.
        return [
            'equal' => [false, '11:12:13', '11:12:13'],

            'greater-second' => [true, '00:00:01', '00:00:00'],
            'greater-second-flipped' => [false, '00:00:00', '00:00:01'],
            'greater-minute' => [true, '00:01:00', '00:00:00'],
            'greater-minute-flipped' => [false, '00:00:00', '00:01:00'],
            'greater-hour' => [true, '01:00:00', '00:00:00'],
            'greater-hour-flipped' => [false, '00:00:00', '01:00:00'],

            'sanity-1' => [true, '01:01:11', '01:01:01'],
            'sanity-2' => [false, '01:21:11', '01:22:01'],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanCheckTimeGreaterThan
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     * @throws TimeInvalidStringFormatException
     */
    public function canCheckTimeGreaterThan(bool $expected, string $base, string $comparison): void
    {
        $a = Time::createFromStringFull($base);
        $b = Time::createFromStringFull($comparison);

        $response = $a->isGreaterThan($b);

        self::assertEquals($expected, $response);
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanCheckTimeGreaterThanOrEqual(): array
    {
        // First date is the base, the second is the comparison.
        // Think of it as left side greater than right side.
        return [
            'equal' => [true, '11:12:13', '11:12:13'],
            'equal-zero' => [true, '00:00:00', '00:00:00'],
            'equal-maximum' => [true, '23:59:59', '23:59:59'],
            'equal-mixture' => [false, '00:00:00', '23:59:59'],
            'equal-mixture-flipped' => [true, '23:59:59', '00:00:00'],

            'greater-second' => [true, '00:00:01', '00:00:00'],
            'greater-second-flipped' => [false, '00:00:00', '00:00:01'],
            'greater-minute' => [true, '00:01:00', '00:00:00'],
            'greater-minute-flipped' => [false, '00:00:00', '00:01:00'],
            'greater-hour' => [true, '01:00:00', '00:00:00'],
            'greater-hour-flipped' => [false, '00:00:00', '01:00:00'],

            'sanity-1' => [true, '01:01:11', '01:01:01'],
            'sanity-2' => [false, '01:21:11', '01:22:01'],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanCheckTimeGreaterThanOrEqual
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     * @throws TimeInvalidStringFormatException
     */
    public function canCheckTimeGreaterThanOrEqual(bool $expected, string $base, string $comparison): void
    {
        $a = Time::createFromStringFull($base);
        $b = Time::createFromStringFull($comparison);

        $response = $a->isGreaterThanOrEqual($b);

        self::assertEquals($expected, $response);
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanCheckTimeLessThan(): array
    {
        // First date is the base, the second is the comparison.
        // Think of it as left side less than right side.
        return [
            'equal' => [false, '11:12:13', '11:12:13'],

            'less-second' => [false, '00:00:01', '00:00:00'],
            'less-second-flipped' => [true, '00:00:00', '00:00:01'],
            'less-minute' => [false, '00:01:00', '00:00:00'],
            'less-minute-flipped' => [true, '00:00:00', '00:01:00'],
            'less-hour' => [false, '01:00:00', '00:00:00'],
            'less-hour-flipped' => [true, '00:00:00', '01:00:00'],

            'sanity-1' => [false, '01:01:11', '01:01:01'],
            'sanity-2' => [true, '01:21:11', '01:22:01'],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanCheckTimeLessThan
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     * @throws TimeInvalidStringFormatException
     */
    public function canCheckTimeLessThan(bool $expected, string $base, string $comparison): void
    {
        $a = Time::createFromStringFull($base);
        $b = Time::createFromStringFull($comparison);

        $response = $a->isLessThan($b);

        self::assertEquals($expected, $response);
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanCheckTimeLessThanOrEqual(): array
    {
        // First date is the base, the second is the comparison.
        // Think of it as left side less than right side.
        return [
            'equal' => [true, '11:12:13', '11:12:13'],
            'equal-zero' => [true, '00:00:00', '00:00:00'],
            'equal-maximum' => [true, '23:59:59', '23:59:59'],
            'equal-mixture' => [true, '00:00:00', '23:59:59'],
            'equal-mixture-flipped' => [false, '23:59:59', '00:00:00'],

            'less-second' => [false, '00:00:01', '00:00:00'],
            'less-second-flipped' => [true, '00:00:00', '00:00:01'],
            'less-minute' => [false, '00:01:00', '00:00:00'],
            'less-minute-flipped' => [true, '00:00:00', '00:01:00'],
            'less-hour' => [false, '01:00:00', '00:00:00'],
            'less-hour-flipped' => [true, '00:00:00', '01:00:00'],

            'sanity-1' => [false, '01:01:11', '01:01:01'],
            'sanity-2' => [true, '01:21:11', '01:22:01'],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanCheckTimeLessThanOrEqual
     *
     * @throws TimeInvalidHourException
     * @throws TimeInvalidMinuteException
     * @throws TimeInvalidSecondException
     * @throws TimeInvalidStringFormatException
     */
    public function canCheckTimeLessThanOrEqual(bool $expected, string $base, string $comparison): void
    {
        $a = Time::createFromStringFull($base);
        $b = Time::createFromStringFull($comparison);

        $response = $a->isLessThanOrEqual($b);

        self::assertEquals($expected, $response);
    }
}
