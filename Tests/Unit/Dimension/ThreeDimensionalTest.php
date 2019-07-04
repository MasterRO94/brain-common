<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Dimension;

use Brain\Common\Dimension\ThreeDimensional;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 * @group dimension
 *
 * @covers \Brain\Common\Dimension\ThreeDimensional
 */
final class ThreeDimensionalTest extends TestCase
{
    /**
     * @test
     */
    public function canCreateZeroDimension(): void
    {
        $dimension = ThreeDimensional::createZero();

        self::assertEquals(0, $dimension->getWidth());
        self::assertEquals(0, $dimension->getHeight());
        self::assertEquals(0, $dimension->getDepth());
    }

    /**
     * @test
     */
    public function canGetWidthAndHeight(): void
    {
        $dimension = new ThreeDimensional(10, 20, 30);

        self::assertEquals(10, $dimension->getWidth());
        self::assertEquals(20, $dimension->getHeight());
        self::assertEquals(30, $dimension->getDepth());
    }

    /**
     * @test
     */
    public function canDetectZeroIsNotSquare(): void
    {
        $zero = ThreeDimensional::createZero();

        self::assertFalse($zero->isSquare());
    }

    /**
     * @test
     */
    public function canDetectIsSquare(): void
    {
        $a = new ThreeDimensional(10, 10, 10);
        $b = new ThreeDimensional(10, 15, 10);

        self::assertTrue($a->isSquare());
        self::assertFalse($b->isSquare());
    }

    /**
     * @test
     */
    public function canDetectZeroIsNotCube(): void
    {
        $zero = ThreeDimensional::createZero();

        self::assertFalse($zero->isCube());
    }

    /**
     * @test
     */
    public function canDetectIsCube(): void
    {
        $a = new ThreeDimensional(10, 10, 10);
        $b = new ThreeDimensional(10, 15, 10);

        self::assertTrue($a->isCube());
        self::assertFalse($b->isCube());
    }

    /**
     * @test
     */
    public function canConvertToString(): void
    {
        $dimension = new ThreeDimensional(10, 20, 30);

        $expected = '10x20x30';

        self::assertEquals($expected, $dimension->toString());
    }

    /**
     * @test
     */
    public function canConvertToArray(): void
    {
        $dimension = new ThreeDimensional(10, 20, 30);

        $expected = [
            'width' => 10,
            'height' => 20,
            'depth' => 30,
        ];

        self::assertEquals($expected, $dimension->toArray());
    }

    /**
     * @test
     */
    public function canRepresentWithDebug(): void
    {
        $dimension = new ThreeDimensional(10, 20, 30);

        $expected = 'ThreeDimensional{width=10, height=20, depth=30}';

        self::assertEquals($expected, $dimension->toDebug(true));
    }
}
