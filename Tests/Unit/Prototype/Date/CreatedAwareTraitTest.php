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
 * @covers \Brain\Common\Prototype\Column\Date\CreatedAwareTrait
 */
final class CreatedAwareTraitTest extends TestCase
{
    /**
     * @test
     */
    public function canDetectMissingDate(): void
    {
        $instance = new DateAwarePrototypeTestFixture();

        self::assertFalse($instance->hasCreatedAt());
    }

    /**
     * @test
     */
    public function withMissingDateGetterThrows(): void
    {
        $instance = new DateAwarePrototypeTestFixture();

        self::expectException(PrototypeMethodException::class);
        self::expectExceptionMessageRegExp('/getCreatedAt/');

        $instance->getCreatedAt();
    }

    /**
     * @test
     */
    public function canSetDate(): void
    {
        $date = new DateTimeImmutable();

        $instance = new DateAwarePrototypeTestFixture();
        $instance->setCreatedAt($date);

        self::assertTrue($instance->hasCreatedAt());
        self::assertSame($date, $instance->getCreatedAt());
    }
}
