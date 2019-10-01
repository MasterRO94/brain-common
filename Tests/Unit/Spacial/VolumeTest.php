<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Spacial;

use Brain\Common\Dimension\ThreeDimensional;
use Brain\Common\Spacial\Volume;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 *
 * @covers \Brain\Common\Spacial\Volume
 */
final class VolumeTest extends TestCase
{
    /**
     * @test
     */
    public function canCreateVolume(): void
    {
        $volume = new Volume(100);

        self::assertEquals(100, $volume->toInteger());
    }

    /**
     * @test
     */
    public function canCheckVolumeLessThanOtherVolume(): void
    {
        $a = new Volume(100);
        $b = new Volume(200);
        $c = new Volume(300);

        self::assertTrue($a->isLessThanOrEqual($b));
        self::assertTrue($b->isLessThanOrEqual($c));

        self::assertFalse($b->isLessThanOrEqual($a));
        self::assertFalse($c->isLessThanOrEqual($b));
    }

    /**
     * @test
     */
    public function canAllowVolumeLessThanWhenExact(): void
    {
        $a = new Volume(123);
        $b = new Volume(123);

        self::assertTrue($a->isLessThanOrEqual($b));
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanCheckTwoDimensionalLessThan(): array
    {
        return [
            [false, 200, 10, 15, 1],
            [true, 200, 15, 15, 1],

            [false, 800, 10, 15, 5],
            [true, 800, 15, 15, 15],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanCheckTwoDimensionalLessThan
     */
    public function canCheckTwoDimensionalLessThan(bool $expected, int $volume, int $width, int $height, int $depth): void
    {
        $dimension = new ThreeDimensional($width, $height, $depth);

        self::assertEquals($expected, (new Volume($volume))->isLessThanOrEqualToThreeDimensional($dimension));
    }
}
