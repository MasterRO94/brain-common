<?php

namespace Brain\Common\Tests\Unit\Assert\Type;

use Brain\Common\Assert\Exception\Type\ArrayTypeEmptyAssertException;
use Brain\Common\Assert\Exception\Type\ArrayTypeInvalidTypeAssertException;
use Brain\Common\Assert\Type\ArrayTypeAssert;
use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 * @group assert
 *
 * @covers \Brain\Common\Assert\Type\ArrayTypeAssert
 * @covers \Brain\Common\Assert\Exception\Type\ArrayTypeEmptyAssertException
 * @covers \Brain\Common\Assert\Exception\Type\ArrayTypeInvalidTypeAssertException
 */
final class ArrayTypeAssertTest extends TestCase
{
    /**
     * @test
     *
     * @throws ArrayTypeEmptyAssertException
     */
    public function withEmptyArrayAssertNotEmptyThrow(): void
    {
        self::expectException(ArrayTypeEmptyAssertException::class);
        self::expectExceptionMessage('The given array cannot be empty.');

        ArrayTypeAssert::assertNotEmpty([]);
    }

    /**
     * @test
     *
     * @throws ArrayTypeEmptyAssertException
     */
    public function canAssertNotEmpty(): void
    {
        ArrayTypeAssert::assertNotEmpty([1, 2, 3]);

        /** @var mixed $mixed */
        $mixed = true;

        self::assertTrue($mixed);
    }

    /**
     * @test
     *
     * @throws ArrayTypeInvalidTypeAssertException
     */
    public function withInvalidTypeAssertIntegerArrayThrow(): void
    {
        self::expectException(ArrayTypeInvalidTypeAssertException::class);
        self::expectExceptionMessage('The given array must be an array of integer(s).');

        ArrayTypeAssert::assertIntegerArray(['foo']);
    }

    /**
     * @test
     *
     * @throws ArrayTypeInvalidTypeAssertException
     */
    public function canAssertEmptyArrayIntegerArray(): void
    {
        ArrayTypeAssert::assertIntegerArray([]);

        /** @var mixed $mixed */
        $mixed = true;

        self::assertTrue($mixed);
    }

    /**
     * @test
     *
     * @throws ArrayTypeInvalidTypeAssertException
     */
    public function canAssertIntegerArrayIsIntegerArray(): void
    {
        ArrayTypeAssert::assertIntegerArray([1, 2, 3]);

        /** @var mixed $mixed */
        $mixed = true;

        self::assertTrue($mixed);
    }
}
