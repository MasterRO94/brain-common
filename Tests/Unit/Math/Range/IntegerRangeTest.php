<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Math\Range;

use Brain\Common\Math\Exception\Range\IntegerRangeNotPositiveException;
use Brain\Common\Math\Range\IntegerRange;

use PHPUnit\Framework\TestCase;

/**
 * @group unit
 * @group common
 * @group math
 *
 * @covers \Brain\Common\Math\Range\IntegerRange
 */
final class IntegerRangeTest extends TestCase
{
    /**
     * @test
     */
    public function canCreateIntegerRange(): void
    {
        $range = IntegerRange::create(1, 10);

        self::assertEquals(1, $range->start());
        self::assertEquals(10, $range->finish());
    }

    /**
     * @test
     */
    public function canCheckIsNotRange(): void
    {
        self::assertFalse(IntegerRange::create(1, 1)->isRange());
    }

    /**
     * @test
     */
    public function canCheckIsRange(): void
    {
        self::assertTrue(IntegerRange::create(1, 2)->isRange());
        self::assertTrue(IntegerRange::create(2, 1)->isRange());
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanCheckRangeIsNatural(): array
    {
        return [
            [true, 1, 1],
            [true, 1, 2],
            [true, 2, 2],
            [true, 2, 10],
            [true, 100, 1000],

            // Controversial decision, zero is not natural
            [false, 0, 0],
            [false, 0, 10],

            [false, -1, 0],
            [false, -10, 0],
            [false, -10, 1],
            [false, -10, 10],

            [false, -1, -1],
            [false, -1, -2],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanCheckRangeIsNatural
     */
    public function canCheckRangeIsNatural(bool $expected, int $start, int $finish): void
    {
        $range = IntegerRange::create($start, $finish);

        self::assertEquals($start, $range->start());
        self::assertEquals($finish, $range->finish());
        self::assertEquals($expected, $range->isNatural());
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanCheckRangeIsForward(): array
    {
        return [
            [false, 0, 0],
            [false, 1, 1],
            [false, -1, -1],

            [true, 0, 1],
            [true, 1, 2],
            [true, 1, 10],

            [true, -1, 10],
            [true, -10, 10],
            [true, -10, 0],

            [true, -10, -1],
            [true, -10, -2],

            [false, -1, -2],
            [false, -1, -20],
            [false, 0, -20],
            [false, 10, -20],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanCheckRangeIsForward
     */
    public function canCheckRangeIsForward(bool $expected, int $start, int $finish): void
    {
        $range = IntegerRange::create($start, $finish);

        self::assertEquals($start, $range->start());
        self::assertEquals($finish, $range->finish());
        self::assertEquals($expected, $range->isForward());
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanCheckRangeIsBackward(): array
    {
        return [
            [false, 0, 0],
            [false, 1, 1],
            [false, -1, -1],

            [true, 1, 0],
            [true, 2, 1],
            [true, 10, 1],

            [true, 10, -1],
            [true, 10, -10],
            [true, 0, -10],

            [true, -1, -10],
            [true, -2, -10],

            [false, -2, -1],
            [false, -20, -1],
            [false, -20, 0],
            [false, -20, 10],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanCheckRangeIsBackward
     */
    public function canCheckRangeIsBackward(bool $expected, int $start, int $finish): void
    {
        $range = IntegerRange::create($start, $finish);

        self::assertEquals($start, $range->start());
        self::assertEquals($finish, $range->finish());
        self::assertEquals($expected, $range->isBackward());
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanCheckValueWithinRange(): array
    {
        return [
            [false, 1, 10, 0],
            [false, 1, 10, 0.9],
            [false, 1, 10, 11],
            [false, 1, 10, 10.1],

            [true, 1, 10, 1],
            [true, 1, 10, 10],
            [true, 1, 10, 2],
            [true, 1, 10, 3],

            // Reversed ranges, so facing backwards.
            [true, 10, 1, 1],
            [true, 10, 1, 10],
            [true, 10, 1, 2],
            [true, 10, 1, 3],

            // Non ranges.
            [true, 1, 1, 1],
            [false, 1, 1, 1.1],
            [false, 1, 1, 0.9],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanCheckValueWithinRange
     *
     * @param int|float $numeric
     */
    public function canCheckValueWithinRange(bool $expected, int $start, int $finish, $numeric): void
    {
        $range = IntegerRange::create($start, $finish);

        self::assertEquals($start, $range->start());
        self::assertEquals($finish, $range->finish());
        self::assertEquals($expected, $range->isWithin($numeric));
    }

    /**
     * @test
     */
    public function canCalculateDistanceBetweenNonRange(): void
    {
        self::assertEquals(0, IntegerRange::create(1, 1)->distance());
    }

    /**
     * @test
     */
    public function canCalculateDistanceBetweenRange(): void
    {
        self::assertEquals(1, IntegerRange::create(1, 2)->distance());
        self::assertEquals(2, IntegerRange::create(1, 3)->distance());
        self::assertEquals(2, IntegerRange::create(-1, 1)->distance());
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanRepresentRangeAsString(): array
    {
        return [
            ['0:0', 0, 0],
            ['0:1', 0, 1],
            ['1:1', 1, 1],
            ['1:10', 1, 10],
            ['-1:10', -1, 10],
            ['-1:-10', -1, -10],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanRepresentRangeAsString
     */
    public function canRepresentRangeAsString(string $expected, int $start, int $finish): void
    {
        $range = IntegerRange::create($start, $finish);

        self::assertEquals($expected, $range->toString());
    }

    /**
     * @test
     */
    public function canRepresentRangeAsArray(): void
    {
        $range = IntegerRange::create(1, 10);

        $expected = [1, 10];

        self::assertEquals($expected, $range->toArray());
    }

    /**
     * @test
     */
    public function canMagicStringCast(): void
    {
        $range = IntegerRange::create(1, 123);

        self::assertEquals('1:123', $range);
    }

    /**
     * @test
     */
    public function withNegativeRangeCreatePositiveThrow(): void
    {
        try {
            IntegerRange::createForwardRange(20, 10);
        } catch (IntegerRangeNotPositiveException $exception) {
            $message = 'The integer range must be positive, finish value 20 must be greater or equal to start 10.';

            self::assertEquals($message, $exception->getMessage());
            self::assertEquals(20, $exception->getRangeStart());
            self::assertEquals(10, $exception->getRangeFinish());

            return;
        }

        self::fail(sprintf('Expected exception: %s', IntegerRangeNotPositiveException::class));
    }

    /**
     * @test
     *
     * @throws IntegerRangeNotPositiveException
     */
    public function canCreatePositiveNonRange(): void
    {
        $range = IntegerRange::createForwardRange(1, 1);

        self::assertEquals(1, $range->start());
        self::assertEquals(1, $range->finish());
    }

    /**
     * @test
     *
     * @throws IntegerRangeNotPositiveException
     */
    public function canCreatePositiveRange(): void
    {
        $range = IntegerRange::createForwardRange(1, 10);

        self::assertEquals(1, $range->start());
        self::assertEquals(10, $range->finish());
    }
}
