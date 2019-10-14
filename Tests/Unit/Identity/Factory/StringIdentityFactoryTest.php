<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Identity\Factory;

use Brain\Common\Identity\Factory\StringIdentityFactory;
use Brain\Common\Utility\UniqueIdentityFactoryInterface;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 * @group identity
 *
 * @covers \Brain\Common\Identity\Factory\StringIdentityFactory
 */
final class StringIdentityFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function canCreateFromUniqueIdentityFactory(): void
    {
        /** @var UniqueIdentityFactoryInterface|MockObject $uuid */
        $uuid = $this->createMock(UniqueIdentityFactoryInterface::class);
        $uuid->expects(self::once())
            ->method('uuid')
            ->willReturn('c199d898-d3d3-43a5-aeff-d10897feb7fb');

        $identity = (new StringIdentityFactory($uuid))->create();

        self::assertEquals('c199d898-d3d3-43a5-aeff-d10897feb7fb', $identity->toString());
    }
}
