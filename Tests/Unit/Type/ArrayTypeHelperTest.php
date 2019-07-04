<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Type;

use Brain\Common\Type\ArrayTypeHelper;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 * @group type
 *
 * @covers \Brain\Common\Type\ArrayTypeHelper
 */
final class ArrayTypeHelperTest extends TestCase
{
    /**
     * @test
     */
    public function canDetectEmptyArray(): void
    {
        self::assertTrue(ArrayTypeHelper::isEmpty([]));

        self::assertFalse(ArrayTypeHelper::isEmpty([1]));
        self::assertFalse(ArrayTypeHelper::isEmpty([1, 2]));
        self::assertFalse(ArrayTypeHelper::isEmpty(['foo']));
    }

    /**
     * @test
     */
    public function canDetectEmptyArrayAsIntegerArray(): void
    {
        self::assertTrue(ArrayTypeHelper::isIntegerArray([]));
    }

    /**
     * @test
     */
    public function canDetectArrayAsIntegerArray(): void
    {
        self::assertTrue(ArrayTypeHelper::isIntegerArray([1]));
        self::assertTrue(ArrayTypeHelper::isIntegerArray([1, 2]));
    }

    /**
     * @test
     */
    public function canDetectArrayNotIntegerArray(): void
    {
        self::assertFalse(ArrayTypeHelper::isIntegerArray(['foo']));
        self::assertFalse(ArrayTypeHelper::isIntegerArray([1.2]));
    }
}
