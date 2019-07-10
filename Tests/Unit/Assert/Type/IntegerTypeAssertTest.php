<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Assert\Type;

use Brain\Common\Assert\Exception\Type\IntegerTypeAboveValueException;
use Brain\Common\Assert\Exception\Type\IntegerTypeRangeException;
use Brain\Common\Assert\Type\IntegerTypeAssert;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 * @group assert
 *
 * @covers \Brain\Common\Assert\Type\IntegerTypeAssert
 * @covers \Brain\Common\Assert\Exception\Type\IntegerTypeAboveValueException
 * @covers \Brain\Common\Assert\Exception\Type\IntegerTypeRangeException
 */
final class IntegerTypeAssertTest extends TestCase
{
    /**
     * @test
     *
     * @throws IntegerTypeAboveValueException
     */
    public function withInvalidValueAboveThresholdThrow(): void
    {
        self::expectException(IntegerTypeAboveValueException::class);
        self::expectExceptionMessage('The given value (foo) 5 is not above 10.');

        IntegerTypeAssert::assertAboveThreshold(5, 10, 'foo');
    }

    /**
     * @test
     *
     * @throws IntegerTypeAboveValueException
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
     * @throws IntegerTypeRangeException
     */
    public function withInvalidValueAssertWithinRangeThrow(): void
    {
        self::expectException(IntegerTypeRangeException::class);
        self::expectExceptionMessage('The given value 0 is not within the expected range 10 to 20.');

        IntegerTypeAssert::assertWithinRange(0, 10, 20);
    }

    /**
     * @test
     *
     * @throws IntegerTypeRangeException
     */
    public function canAssertIntegerWithinRange(): void
    {
        IntegerTypeAssert::assertWithinRange(5, 1, 10);

        /** @var mixed $mixed */
        $mixed = true;

        self::assertTrue($mixed);
    }
}
