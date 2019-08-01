<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Assert\Type;

use Brain\Common\Assert\Exception\Type\StringTypeNotEmptyAssertException;
use Brain\Common\Assert\Type\StringTypeAssert;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 * @group assert
 *
 * @covers \Brain\Common\Assert\Type\StringTypeAssert
 * @covers \Brain\Common\Assert\Exception\Type\StringTypeNotEmptyAssertException
 */
final class StringTypeAssertTest extends TestCase
{
    /**
     * @test
     *
     * @throws StringTypeNotEmptyAssertException
     */
    public function withEmptyStringAssertNotEmpty(): void
    {
        self::expectException(StringTypeNotEmptyAssertException::class);
        self::expectExceptionMessage('The given string value (foo) cannot be empty');

        StringTypeAssert::assertNotEmpty('', 'foo');
    }

    /**
     * @test
     *
     * @throws StringTypeNotEmptyAssertException
     */
    public function canAssertNotEmpty(): void
    {
        StringTypeAssert::assertNotEmpty('bar', 'foo');

        /** @var mixed $mixed */
        $mixed = true;

        self::assertTrue($mixed);
    }
}
