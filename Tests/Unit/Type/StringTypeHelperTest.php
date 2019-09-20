<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Type;

use Brain\Common\Type\Exception\StringNotNumericException;
use Brain\Common\Type\StringTypeHelper;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 * @group type
 *
 * @covers \Brain\Common\Type\StringTypeHelper
 */
final class StringTypeHelperTest extends TestCase
{
    /**
     * @test
     */
    public function withNonNumericValueToIntegerThrow(): void
    {
        try {
            StringTypeHelper::toInteger('1234 NUMBER');
        } catch (StringNotNumericException $exception) {
            $message = 'The string "1234 NUMBER" is not numeric.';

            self::assertEquals($message, $exception->getMessage());

            return;
        }

        self::fail(sprintf('Expected exception: %s', StringNotNumericException::class));
    }

    /**
     * @test
     *
     * @throws StringNotNumericException
     */
    public function canCastToInteger(): void
    {
        $integer = StringTypeHelper::toInteger('1234');

        self::assertEquals(1234, $integer);
    }
}
