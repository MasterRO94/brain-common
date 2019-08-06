<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Prototype\Date\Setup;

use Brain\Common\Date\DateTimeFactoryInterface;
use Brain\Common\Prototype\Column\Date\Setup\DatePrototypeSetup;
use Brain\Common\Tests\Fixture\Prototype\Date\DateAwarePrototypeTestFixture;

use DateTimeImmutable;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 * @group common
 * @group prototype
 *
 * @covers \Brain\Common\Prototype\Column\Date\Setup\DatePrototypeSetup
 */
final class DatePrototypeSetupTest extends TestCase
{
    /**
     * @test
     */
    public function canSetupDatePrototypes(): void
    {
        /** @var DateTimeFactoryInterface|MockObject $factory */
        $factory = $this->createMock(DateTimeFactoryInterface::class);
        $factory->expects(self::once())
            ->method('createImmutable')
            ->willReturn(new DateTimeImmutable());

        $instance = new DateAwarePrototypeTestFixture();

        self::assertFalse($instance->hasCreatedAt());
        self::assertFalse($instance->hasUpdatedAt());
        self::assertFalse($instance->hasDeletedAt());

        $setup = new DatePrototypeSetup($factory);
        $setup->setup($instance);

        self::assertTrue($instance->hasCreatedAt());
        self::assertTrue($instance->hasUpdatedAt());
        self::assertFalse($instance->hasDeletedAt());
    }
}
