<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Assert\Type;

use Brain\Common\Assert\Exception\Type\IntegerTypeAboveValueAssertException;
use Brain\Common\Assert\Exception\Type\IntegerTypeRangeAssertException;
use Brain\Common\Assert\Type\IntegerTypeAssert;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 * @group assert
 *
 * @covers \Brain\Common\Assert\Type\IntegerTypeAssert
 * @covers \Brain\Common\Assert\Exception\Type\IntegerTypeAboveValueAssertException
 * @covers \Brain\Common\Assert\Exception\Type\IntegerTypeRangeAssertException
 */
final class IntegerTypeAssertTest extends TestCase
{
    /**
     * @test
     *
     * @throws IntegerTypeAboveValueAssertException
     */
    public function withInvalidValueAboveThresholdThrow(): void
    {
        self::expectException(IntegerTypeAboveValueAssertException::class);
        self::expectExceptionMessage('The given integer value (foo) 5 is not above 10');

        IntegerTypeAssert::assertAboveThreshold(5, 10, 'foo');
    }

    /**
     * @test
     *
     * @throws IntegerTypeAboveValueAssertException
     */
    public function canAssertIntegerAboveThreshold(): void
    {
        IntegerTypeAssert::assertAboveThreshold(1, 0, 'foo');

        /** @var mixed $mixed */
        $mixed = true;

        self::assertTrue($mixed);
    }

    /**
     * @test
     *
     * @throws IntegerTypeRangeAssertException
     */
    public function withInvalidValueAssertWithinRangeThrow(): void
    {
        self::expectException(IntegerTypeRangeAssertException::class);
        self::expectExceptionMessage('The given value 0 is not within the expected range 10 to 20');

        IntegerTypeAssert::assertWithinRange(0, 10, 20);
    }

    /**
     * @test
     *
     * @throws IntegerTypeRangeAssertException
     */
    public function canAssertIntegerWithinRange(): void
    {
        IntegerTypeAssert::assertWithinRange(5, 1, 10);

        /** @var mixed $mixed */
        $mixed = true;

        self::assertTrue($mixed);
    }
}
