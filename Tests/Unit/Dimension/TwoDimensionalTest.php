<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Dimension;

use Brain\Common\Dimension\TwoDimensional;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 * @group dimension
 *
 * @covers \Brain\Common\Dimension\TwoDimensional
 */
final class TwoDimensionalTest extends TestCase
{
    /**
     * @test
     */
    public function canCreateZeroDimension(): void
    {
        $dimension = TwoDimensional::createZero();

        self::assertEquals(0, $dimension->getWidth());
        self::assertEquals(0, $dimension->getHeight());
    }

    /**
     * @test
     */
    public function canGetWidthAndHeight(): void
    {
        $dimension = new TwoDimensional(10, 20);

        self::assertEquals(10, $dimension->getWidth());
        self::assertEquals(20, $dimension->getHeight());
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanGetArea(): array
    {
        return [
            [0, 0, 0],
            [0, 1, 0],
            [0, 0, 1],

            [100, 10, 10],
            [1000, 20, 50],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanGetArea
     */
    public function canGetArea(int $expected, int $width, int $height): void
    {
        $dimension = new TwoDimensional($width, $height);

        self::assertEquals($expected, $dimension->getArea()->toInteger());
    }

    /**
     * @test
     */
    public function canDetectZeroIsNotSquare(): void
    {
        $zero = TwoDimensional::createZero();

        self::assertFalse($zero->isSquare());
    }

    /**
     * @test
     */
    public function canDetectIsSquare(): void
    {
        $a = new TwoDimensional(10, 10);
        $b = new TwoDimensional(10, 15);

        self::assertTrue($a->isSquare());
        self::assertFalse($b->isSquare());
    }

    /**
     * @test
     */
    public function canConvertToString(): void
    {
        $dimension = new TwoDimensional(10, 20);

        $expected = '10x20';

        self::assertEquals($expected, $dimension->toString());
    }

    /**
     * @test
     */
    public function canConvertToArray(): void
    {
        $dimension = new TwoDimensional(10, 20);

        $expected = [
            'width' => 10,
            'height' => 20,
        ];

        self::assertEquals($expected, $dimension->toArray());
    }

    /**
     * @test
     */
    public function canRepresentWithDebug(): void
    {
        $dimension = new TwoDimensional(10, 20);

        $expected = 'TwoDimensional{width=10, height=20}';

        self::assertEquals($expected, $dimension->toDebug(true));
    }
}
