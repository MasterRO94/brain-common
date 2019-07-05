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
    public function canCastToInteger(): void
    {
        $casted = IntegerTypeHelper::asInteger('1');

        self::assertEquals(1, $casted);
    }
}
