<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Dimension\Range;

use Brain\Common\Dimension\Range\TwoDimensionalRange;
use Brain\Common\Dimension\TwoDimensional;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 * @group dimension
 *
 * @covers \Brain\Common\Dimension\Range\TwoDimensionalRange
 */
final class TwoDimensionalRangeTest extends TestCase
{
    /**
     * @test
     */
    public function canGetRangeParts(): void
    {
        $a = new TwoDimensional(10, 10);
        $b = new TwoDimensional(30, 30);

        $range = new TwoDimensionalRange($a, $b);

        self::assertSame($a, $range->getMinimumDimension());
        self::assertSame($b, $range->getMaximumDimension());
    }

    /**
     * @test
     */
    public function canConvertToString(): void
    {
        $a = new TwoDimensional(10, 10);
        $b = new TwoDimensional(30, 30);

        $range = new TwoDimensionalRange($a, $b);

        $expected = '10x10-30x30';

        self::assertEquals($expected, $range->toString());
    }

    /**
     * @test
     */
    public function canConvertToArray(): void
    {
        $a = new TwoDimensional(10, 10);
        $b = new TwoDimensional(30, 30);

        $range = new TwoDimensionalRange($a, $b);

        $expected = [
            'minimum' => [
                'width' => 10,
                'height' => 10,
            ],
            'maximum' => [
                'width' => 30,
                'height' => 30,
            ],
        ];

        self::assertEquals($expected, $range->toArray());
    }

    /**
     * @test
     */
    public function canRepresentWithDebug(): void
    {
        $a = new TwoDimensional(10, 10);
        $b = new TwoDimensional(30, 30);

        $range = new TwoDimensionalRange($a, $b);

        $expected = 'TwoDimensionalRange{minimum=TwoDimensional{width=10, height=10}, maximum=TwoDimensional{width=30, height=30}}';

        self::assertEquals($expected, $range->toDebug(true));
    }
}
