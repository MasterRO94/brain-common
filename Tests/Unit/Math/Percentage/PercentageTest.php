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
    public function whenValueOutOfBoundThrow(): void
    {
        try {
            Percentage::create(101);
        } catch (PercentageBoundExceededException $exception) {
            $message = 'The value provided (101) is an invalid percentage value.';

            self::assertEquals($message, $exception->getMessage());
            self::assertEquals(101, $exception->getInvalidValue());

            return;
        }

        self::fail(sprintf('Expected exception: %s', PercentageBoundExceededException::class));
    }

    /**
     * @test
     *
     * @throws PercentageBoundExceededException
     */
    public function canCreatePercentage(): void
    {
        $percentage = Percentage::create(1.123);

        self::assertEquals('1.12%', $percentage->toString());
        self::assertEquals(1, $percentage->toInteger());
        self::assertEquals(1.123, $percentage->toFloat());
    }

    /**
     * @test
     *
     * @throws PercentageBoundExceededException
     */
    public function canCreatePercentageFromInteger(): void
    {
        $percentage = Percentage::create(1);

        self::assertEquals('1.00%', $percentage->toString());
        self::assertEquals(1, $percentage->toInteger());
        self::assertEquals(1, $percentage->toFloat());
    }
}
