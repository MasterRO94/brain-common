<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Type;

use Brain\Common\Type\FloatTypeHelper;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 * @group type
 *
 * @covers \Brain\Common\Type\FloatTypeHelper
 */
final class FloatTypeHelperTest extends TestCase
{
    /**
     * @test
     */
    public function canCastToInteger(): void
    {
        $integer = FloatTypeHelper::toInteger(10.10);

        self::assertEquals(10, $integer);
    }
}
