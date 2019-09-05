<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Math;

use Brain\Common\Math\Rounding;

use PHPUnit\Framework\TestCase;

/**
 * @group unit
 * @group common
 * @group math
 *
 * @covers \Brain\Common\Math\Rounding
 */
final class RoundingTest extends TestCase
{
    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanRoundValue(): array
    {
        return [
            [0, 0, 0],

            [0, 0.1, 0],
            [0.1, 0.11, 1],
            [0.2, 0.15, 1],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanRoundValue
     *
     * @param int|float $expected
     * @param int|float $value
     */
    public function canRoundValue($expected, $value, int $precision): void
    {
        self::assertEquals($expected, Rounding::roundTo($value, $precision));
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanRoundValueToInteger(): array
    {
        return [
            [0, 0],
            [0, 0.1],
            [0, 0.11],
            [0, 0.15],
            [1, 0.5],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanRoundValueToInteger
     *
     * @param int|float $value
     */
    public function canRoundValueToInteger(int $expected, $value): void
    {
        self::assertEquals($expected, Rounding::roundToInteger($value));
    }

    /**
     * @test
     */
    public function canFloorValue(): void
    {
        self::assertEquals(1, Rounding::floor(1.1));
        self::assertEquals(2, Rounding::floor(2.5));
        self::assertEquals(3, Rounding::floor(3.9));
    }

    /**
     * @test
     */
    public function canCeilValue(): void
    {
        self::assertEquals(1, Rounding::floor(1.1));
        self::assertEquals(2, Rounding::floor(2.5));
        self::assertEquals(3, Rounding::floor(3.9));
    }
}
