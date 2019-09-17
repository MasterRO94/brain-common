<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Type;

use Brain\Common\Type\IntegerTypeHelper;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 * @group type
 *
 * @covers \Brain\Common\Type\IntegerTypeHelper
 */
final class IntegerTypeHelperTest extends TestCase
{
    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanCheckBetweenRangeInclusive(): array
    {
        return [
            'closed-range' => [true, 1, 1, 1],
            'below-lower-bound' => [false, 0, 1, 5],
            'on-lower-bound' => [true, 1, 1, 5],
            'within-lower-bound' => [true, 2, 1, 5],
            'within-upper-bound' => [true, 4, 1, 5],
            'on-upper-bound' => [true, 5, 1, 5],
            'over-upper-bound' => [false, 6, 1, 5],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanCheckBetweenRangeInclusive
     */
    public function canCheckBetweenRangeInclusive(bool $expected, int $value, int $lower, int $upper): void
    {
        $response = IntegerTypeHelper::isBetweenInclusive($value, $lower, $upper);

        self::assertEquals($expected, $response);
    }

    /**
     * @test
     */
    public function canCastIntegerToString(): void
    {
        $casted = IntegerTypeHelper::toString(123);

        self::assertEquals('123', $casted);
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanClampValue(): array
    {
        return [
            [0, 0, 1, 0],
            [1, 0, 1, 1],
            [2, 0, 1, 1],

            [10, 5, 15, 10],
            [4, 5, 15, 5],
            [16, 5, 15, 15],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanClampValue
     */
    public function canClampValue(int $input, int $lower, int $upper, int $expected): void
    {
        $output = IntegerTypeHelper::clamp($input, $lower, $upper);
        self::assertEquals($expected, $output);
    }
}
