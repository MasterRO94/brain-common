<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Dimension;

use Brain\Common\Dimension\NullTwoDimensional;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 * @group dimension
 *
 * @covers \Brain\Common\Dimension\NullTwoDimensional
 */
final class NullTwoDimensionalTest extends TestCase
{
    /**
     * @test
     */
    public function canGetWidthAndHeight(): void
    {
        $dimension = new NullTwoDimensional();

        self::assertEquals(0, $dimension->getWidth());
        self::assertEquals(0, $dimension->getHeight());
    }

    /**
     * @test
     */
    public function canDetectIsSquare(): void
    {
        $dimension = new NullTwoDimensional();

        self::assertFalse($dimension->isSquare());
    }

    /**
     * @test
     */
    public function canConvertToString(): void
    {
        $dimension = new NullTwoDimensional();

        $expected = '0x0';

        self::assertEquals($expected, $dimension->toString());
    }

    /**
     * @test
     */
    public function canConvertToArray(): void
    {
        $dimension = new NullTwoDimensional();

        $expected = [
            'width' => 0,
            'height' => 0,
        ];

        self::assertEquals($expected, $dimension->toArray());
    }

    /**
     * @test
     */
    public function canRepresentWithDebug(): void
    {
        $dimension = new NullTwoDimensional();

        $expected = 'NullTwoDimensional{none}';

        self::assertEquals($expected, $dimension->toDebug(true));
    }
}
