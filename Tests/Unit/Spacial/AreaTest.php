<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Spacial;

use Brain\Common\Spacial\Area;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 *
 * @covers \Brain\Common\Spacial\Area
 */
final class AreaTest extends TestCase
{
    /**
     * @test
     */
    public function canCreateArea(): void
    {
        $area = new Area(100);

        self::assertEquals(100, $area->toInteger());
    }

    /**
     * @test
     */
    public function canCheckAreaIsEqual(): void
    {
        $a = new Area(100);
        $b = new Area(100);
        $c = new Area(101);

        self::assertTrue($a->isEqual($b));

        self::assertFalse($a->isEqual($c));
        self::assertFalse($b->isEqual($c));
    }

    /**
     * @test
     */
    public function canCheckLessThan(): void
    {
        $a = new Area(100);
        $b = new Area(200);
        $c = new Area(300);

        self::assertTrue($a->isLessThan($b));
        self::assertTrue($b->isLessThan($c));

        self::assertFalse($b->isLessThan($a));
        self::assertFalse($c->isLessThan($b));
    }

    /**
     * @test
     */
    public function canCheckLessThanWithExactMatch(): void
    {
        $a = new Area(123);
        $b = new Area(123);

        self::assertFalse($a->isLessThan($b));
    }

    /**
     * @test
     */
    public function canCheckLessThanOrEqual(): void
    {
        $a = new Area(100);
        $b = new Area(200);
        $c = new Area(300);

        self::assertTrue($a->isLessThanOrEqual($b));
        self::assertTrue($b->isLessThanOrEqual($c));

        self::assertFalse($b->isLessThanOrEqual($a));
        self::assertFalse($c->isLessThanOrEqual($b));
    }

    /**
     * @test
     */
    public function canCheckLessThanOrEqualWithExactMatch(): void
    {
        $a = new Area(123);
        $b = new Area(123);

        self::assertTrue($a->isLessThanOrEqual($b));
    }

    /**
     * @test
     */
    public function canCheckGreaterThan(): void
    {
        $a = new Area(300);
        $b = new Area(200);
        $c = new Area(100);

        self::assertTrue($a->isGreaterThan($b));
        self::assertTrue($b->isGreaterThan($c));

        self::assertFalse($b->isGreaterThan($a));
        self::assertFalse($c->isGreaterThan($b));
    }

    /**
     * @test
     */
    public function canCheckGreaterThanWithExactMatch(): void
    {
        $a = new Area(123);
        $b = new Area(123);

        self::assertFalse($a->isGreaterThan($b));
    }

    /**
     * @test
     */
    public function canCheckGreaterThanOrEqual(): void
    {
        $a = new Area(300);
        $b = new Area(200);
        $c = new Area(100);

        self::assertTrue($a->isGreaterThanOrEqual($b));
        self::assertTrue($b->isGreaterThanOrEqual($c));

        self::assertFalse($b->isGreaterThanOrEqual($a));
        self::assertFalse($c->isGreaterThanOrEqual($b));
    }

    /**
     * @test
     */
    public function canCheckGreaterThanOrEqualWithExactMatch(): void
    {
        $a = new Area(123);
        $b = new Area(123);

        self::assertTrue($a->isGreaterThanOrEqual($b));
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanCheckTwoDimensionalLessThan(): array
    {
        return [
            [false, 200, 10, 15],
            [true, 200, 15, 15],
        ];
    }

    /**
     * @test
     */
    public function canCheckWithin(): void
    {
        $a = new Area(100);
        $b = new Area(200);
        $c = new Area(300);

        self::assertTrue($b->isWithin($a, $c));
        self::assertTrue($a->isWithin($a, $c));
        self::assertTrue($c->isWithin($a, $c));

        self::assertFalse($a->isWithin($b, $c));
    }
}
