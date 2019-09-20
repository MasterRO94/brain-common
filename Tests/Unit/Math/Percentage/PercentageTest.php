<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Math\Percentage;

use Brain\Common\Math\Exception\Percentage\PercentageBoundExceededException;
use Brain\Common\Math\Percentage\Percentage;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 * @group math
 *
 * @covers \Brain\Common\Math\Percentage\Percentage
 */
final class PercentageTest extends TestCase
{
    /**
     * @test
     */
    public function whenValueOutOfBoundCreateNaturalThrow(): void
    {
        try {
            Percentage::createNatural(101);
        } catch (PercentageBoundExceededException $exception) {
            $message = 'The value provided (101) is an invalid percentage value.';

            self::assertEquals($message, $exception->getMessage());
            self::assertEquals(101, $exception->getInvalidValue());

            return;
        }

        self::fail(sprintf('Expected exception: %s', PercentageBoundExceededException::class));
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanRepresentPercentageAsString(): array
    {
        return [
            ['0.00%', 0],
            ['0.10%', 0.1],
            ['0.11%', 0.111],
            ['0.12%', 0.115],
            ['0.50%', 0.5],
            ['100.00%', 100],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanRepresentPercentageAsString
     */
    public function canRepresentPercentageAsString(string $expected, float $value): void
    {
        $percentage = Percentage::create($value);

        self::assertEquals($expected, $percentage->toString());
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanRepresentPercentageAsInteger(): array
    {
        return [
            [0, 0],
            [0, 0.1],
            [0, 0.111],
            [0, 0.115],
            [1, 0.5],
            [100, 100],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanRepresentPercentageAsInteger
     */
    public function canRepresentPercentageAsInteger(int $expected, float $value): void
    {
        $percentage = Percentage::create($value);

        self::assertEquals($expected, $percentage->toInteger());
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanRepresentPercentageAsFloat(): array
    {
        return [
            [0, 0],
            [0.1, 0.1],
            [0.111, 0.111],
            [0.115, 0.115],
            [0.5, 0.5],
            [100, 100],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanRepresentPercentageAsFloat
     */
    public function canRepresentPercentageAsFloat(float $expected, float $value): void
    {
        $percentage = Percentage::create($value);

        self::assertEquals($expected, $percentage->toFloat());
    }

    /**
     * @test
     */
    public function canRoundPercentage(): void
    {
        $a = Percentage::create(10.8543);

        self::assertEquals(10.8543, $a->toFloat());

        $b = $a->round(3);

        self::assertEquals(10.8543, $a->toFloat());
        self::assertEquals(10.854, $b->toFloat());

        $c = $a->round(1);
        $d = $b->round(1);

        self::assertEquals(10.8543, $a->toFloat());
        self::assertEquals(10.854, $b->toFloat());
        self::assertEquals(10.9, $c->toFloat());
        self::assertEquals(10.9, $d->toFloat());

        $e = $a->round(0);

        self::assertEquals(10.8543, $a->toFloat());
        self::assertEquals(10.854, $b->toFloat());
        self::assertEquals(10.9, $c->toFloat());
        self::assertEquals(10.9, $d->toFloat());
        self::assertEquals(11, $e->toFloat());
    }

    /**
     * @test
     */
    public function canCreatePercentageFromInteger(): void
    {
        $percentage = Percentage::create(1);

        self::assertEquals('1.00%', $percentage->toString());
        self::assertEquals(1, $percentage->toInteger());
        self::assertEquals(1, $percentage->toFloat());
    }

    /**
     * Data provider.
     *
     * @return mixed[]
     */
    public function provideCanCreateFromRange(): array
    {
        return [
            [0, 0, 100],
            [100, 100, 100],

            [10, 10, 100],
            [20, 10, 50],
        ];
    }

    /**
     * @test
     * @dataProvider provideCanCreateFromRange
     *
     * @param int|float $expected
     * @param int|float $position
     */
    public function canCreateFromRange($expected, $position, int $range): void
    {
        $percentage = Percentage::createFromRange($position, $range);

        self::assertEquals($expected, $percentage->toFloat());
    }
}
