<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Assert\Type;

use Brain\Common\Assert\Exception\Type\ArrayTypeEmptyAssertException;
use Brain\Common\Assert\Exception\Type\ArrayTypeInvalidTypeAssertException;
use Brain\Common\Assert\Exception\Type\ArrayTypeKeyMissingAssertException;
use Brain\Common\Assert\Type\ArrayTypeAssert;
use Brain\Common\Tests\Fixture\Representation\WithoutRepresentationTestFixture;

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
        self::expectExceptionMessage('The given array (foo) cannot be empty');

        ArrayTypeAssert::assertNotEmpty([], 'foo');
    }

    /**
     * @test
     *
     * @throws ArrayTypeEmptyAssertException
     */
    public function canAssertNotEmpty(): void
    {
        ArrayTypeAssert::assertNotEmpty([1, 2, 3], 'foo');

        /** @var mixed $mixed */
        $mixed = true;

        self::assertTrue($mixed);
    }

    /**
     * @test
     *
     * @throws ArrayTypeKeyMissingAssertException
     */
    public function withMissingKeyAssertKeyExistsThrow(): void
    {
        self::expectException(ArrayTypeKeyMissingAssertException::class);
        self::expectExceptionMessage('The given array ($data) must contain the key "foo"');

        ArrayTypeAssert::assertKeyExists([], 'foo', '$data');
    }

    /**
     * @test
     *
     * @throws ArrayTypeKeyMissingAssertException
     */
    public function canAssertArrayKeyExists(): void
    {
        $data = [
            'foo' => 'bar',
        ];

        ArrayTypeAssert::assertKeyExists($data, 'foo', '$data');

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
        self::expectExceptionMessage('The given array (foo) must be an array of integer');

        ArrayTypeAssert::assertIntegerArray(['foo'], 'foo');
    }

    /**
     * @test
     *
     * @throws ArrayTypeInvalidTypeAssertException
     */
    public function canAssertEmptyArrayIntegerArray(): void
    {
        ArrayTypeAssert::assertIntegerArray([], 'foo');

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
        ArrayTypeAssert::assertIntegerArray([1, 2, 3], 'foo');

        /** @var mixed $mixed */
        $mixed = true;

        self::assertTrue($mixed);
    }

    /**
     * @test
     *
     * @throws ArrayTypeInvalidTypeAssertException
     */
    public function withInvalidTypeAssertClassArrayThrow(): void
    {
        $class = WithoutRepresentationTestFixture::class;

        self::expectException(ArrayTypeInvalidTypeAssertException::class);
        self::expectExceptionMessage(sprintf('The given array ($data) must be an array of %s', $class));

        ArrayTypeAssert::assertClassArray(['foo'], $class, '$data');
    }

    /**
     * @test
     *
     * @throws ArrayTypeInvalidTypeAssertException
     */
    public function canAssertEmptyArrayClassArray(): void
    {
        $class = WithoutRepresentationTestFixture::class;

        ArrayTypeAssert::assertClassArray([], $class, 'foo');

        /** @var mixed $mixed */
        $mixed = true;

        self::assertTrue($mixed);
    }

    /**
     * @test
     *
     * @throws ArrayTypeInvalidTypeAssertException
     */
    public function canAssertClassArrayIsClassArray(): void
    {
        $class = WithoutRepresentationTestFixture::class;

        $data = [
            new WithoutRepresentationTestFixture(),
            new WithoutRepresentationTestFixture(),
            new WithoutRepresentationTestFixture(),
        ];

        ArrayTypeAssert::assertClassArray($data, $class, 'foo');

        /** @var mixed $mixed */
        $mixed = true;

        self::assertTrue($mixed);
    }
}
