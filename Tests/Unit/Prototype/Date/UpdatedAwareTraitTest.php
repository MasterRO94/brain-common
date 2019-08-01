<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Prototype\Date;

use Brain\Common\Exception\Prototype\PrototypeMethodException;
use Brain\Common\Tests\Fixture\Prototype\Date\DateAwarePrototypeTestFixture;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 * @group common
 * @group prototype
 *
 * @covers \Brain\Common\Prototype\Column\Date\UpdatedAwareTrait
 */
final class UpdatedAwareTraitTest extends TestCase
{
    /**
     * @test
     */
    public function canDetectMissingDate(): void
    {
        $instance = new DateAwarePrototypeTestFixture();

        self::assertFalse($instance->hasUpdatedAt());
    }

    /**
     * @test
     */
    public function withMissingDateGetterThrows(): void
    {
        $instance = new DateAwarePrototypeTestFixture();

        self::expectException(PrototypeMethodException::class);
        self::expectExceptionMessageRegExp('/getUpdatedAt/');

        $instance->getUpdatedAt();
    }

    /**
     * @test
     */
    public function canSetDate(): void
    {
        $date = new DateTimeImmutable();

        $instance = new DateAwarePrototypeTestFixture();
        $instance->setUpdatedAt($date);

        self::assertTrue($instance->hasUpdatedAt());
        self::assertSame($date, $instance->getUpdatedAt());
    }
}
