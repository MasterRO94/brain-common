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
 * @covers \Brain\Common\Prototype\Column\Date\DeletedAwareTrait
 */
final class DeletedAwareTraitTest extends TestCase
{
    /**
     * @test
     */
    public function canDetectMissingDate(): void
    {
        $instance = new DateAwarePrototypeTestFixture();

        self::assertFalse($instance->hasDeletedAt());
    }

    /**
     * @test
     */
    public function withMissingDateGetterThrows(): void
    {
        $instance = new DateAwarePrototypeTestFixture();

        self::expectException(PrototypeMethodException::class);
        self::expectExceptionMessageRegExp('/getDeletedAt/');

        $instance->getDeletedAt();
    }

    /**
     * @test
     */
    public function canSetDate(): void
    {
        $date = new DateTimeImmutable();

        $instance = new DateAwarePrototypeTestFixture();
        $instance->setDeletedAt($date);

        self::assertTrue($instance->hasDeletedAt());
        self::assertSame($date, $instance->getDeletedAt());
    }
}
