<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Date\Assert;

use Brain\Common\Date\Assert\TimeAssert;
use Brain\Common\Date\Exception\Time\TimeInvalidHourException;
use Brain\Common\Date\Exception\Time\TimeInvalidMinuteException;
use Brain\Common\Date\Exception\Time\TimeInvalidSecondException;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 * @group date
 *
 * @covers \Brain\Common\Date\Assert\TimeAssert
 */
final class TimeAssertTest extends TestCase
{
    /**
     * @test
     *
     * @throws TimeInvalidHourException
     */
    public function withNegativeHourThrow(): void
    {
        self::expectException(TimeInvalidHourException::class);
        self::expectExceptionMessage('The value -1 is not a valid hour. Please provide a valid integer value between (inclusive) 0 and 23');

        TimeAssert::assertHourValid(-1);
    }

    /**
     * @test
     *
     * @throws TimeInvalidHourException
     */
    public function withTooBigHourThrow(): void
    {
        self::expectException(TimeInvalidHourException::class);
        self::expectExceptionMessage('The value 100 is not a valid hour. Please provide a valid integer value between (inclusive) 0 and 23');

        TimeAssert::assertHourValid(100);
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanAcceptValidHourValues(): array
    {
        $values = [];

        foreach (range(0, 23) as $value) {
            $values[] = [$value];
        }

        return $values;
    }

    /**
     * @test
     * @dataProvider provideCanAcceptValidHourValues
     *
     * @throws TimeInvalidHourException
     */
    public function canAcceptValidHourValues(int $hour): void
    {
        TimeAssert::assertHourValid($hour);

        /** @var mixed $mixed */
        $mixed = true;

        self::assertTrue($mixed);
    }

    /**
     * @test
     *
     * @throws TimeInvalidMinuteException
     */
    public function withNegativeMinuteThrow(): void
    {
        self::expectException(TimeInvalidMinuteException::class);
        self::expectExceptionMessage('The value -1 is not a valid minute. Please provide a valid integer value between (inclusive) 0 and 59');

        TimeAssert::assertMinuteValid(-1);
    }

    /**
     * @test
     *
     * @throws TimeInvalidMinuteException
     */
    public function withTooBigMinuteThrow(): void
    {
        self::expectException(TimeInvalidMinuteException::class);
        self::expectExceptionMessage('The value 100 is not a valid minute. Please provide a valid integer value between (inclusive) 0 and 59');

        TimeAssert::assertMinuteValid(100);
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanAcceptValidMinuteValues(): array
    {
        $values = [];

        foreach (range(0, 59) as $value) {
            $values[] = [$value];
        }

        return $values;
    }

    /**
     * @test
     * @dataProvider provideCanAcceptValidMinuteValues
     *
     * @throws TimeInvalidMinuteException
     */
    public function canAcceptValidMinuteValues(int $minute): void
    {
        TimeAssert::assertMinuteValid($minute);

        /** @var mixed $mixed */
        $mixed = true;

        self::assertTrue($mixed);
    }

    /**
     * @test
     *
     * @throws TimeInvalidSecondException
     */
    public function withNegativeSecondThrow(): void
    {
        self::expectException(TimeInvalidSecondException::class);
        self::expectExceptionMessage('The value -1 is not a valid second. Please provide a valid integer value between (inclusive) 0 and 59');

        TimeAssert::assertSecondValid(-1);
    }

    /**
     * @test
     *
     * @throws TimeInvalidSecondException
     */
    public function withTooBigSecondThrow(): void
    {
        self::expectException(TimeInvalidSecondException::class);
        self::expectExceptionMessage('The value 100 is not a valid second. Please provide a valid integer value between (inclusive) 0 and 59');

        TimeAssert::assertSecondValid(100);
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanAcceptValidSecondValues(): array
    {
        $values = [];

        foreach (range(0, 59) as $value) {
            $values[] = [$value];
        }

        return $values;
    }

    /**
     * @test
     * @dataProvider provideCanAcceptValidSecondValues
     *
     * @throws TimeInvalidSecondException
     */
    public function canAcceptValidSecondValues(int $second): void
    {
        TimeAssert::assertSecondValid($second);

        /** @var mixed $mixed */
        $mixed = true;

        self::assertTrue($mixed);
    }
}
