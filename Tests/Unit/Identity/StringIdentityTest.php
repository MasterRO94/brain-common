<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Identity;

use Brain\Common\Identity\Exception\StringIdentityInvalidException;
use Brain\Common\Identity\StringIdentity;

use PHPUnit\Framework\TestCase;

/**
 * @group common
 * @group unit
 * @group identity
 *
 * @covers \Brain\Common\Identity\StringIdentity
 * @covers \Brain\Common\Identity\Exception\StringIdentityInvalidException
 */
final class StringIdentityTest extends TestCase
{
    /**
     * @test
     */
    public function withInvalidStringCreateThrow(): void
    {
        try {
            StringIdentity::create('asdf');
        } catch (StringIdentityInvalidException $exception) {
            $expected = implode(' ', [
                'The given identity "asdf" is invalid.',
                'Please provide a valid UUID formatted string.',
            ]);

            self::assertEquals($expected, $exception->getMessage());
            self::assertEquals('asdf', $exception->getInvalidId());

            return;
        }

        self::fail(sprintf('Expected exception: %s', StringIdentityInvalidException::class));
    }

    /**
     * @test
     *
     * @throws StringIdentityInvalidException
     */
    public function canConstructStringIdentity(): void
    {
        $uuid = StringIdentity::create('f571d881-4a16-47bb-9601-8077a629f7a3');

        self::assertEquals('f571d881-4a16-47bb-9601-8077a629f7a3', $uuid->toString());
    }

    /**
     * @test
     *
     * @throws StringIdentityInvalidException
     */
    public function canCheckIdentityIsEqual(): void
    {
        $a = StringIdentity::create('f571d881-4a16-47bb-9601-8077a629f7a3');
        $b = StringIdentity::create('fdabbc20-f335-4c27-9b8b-88a0d836f9bd');
        $c = StringIdentity::create('ef15bce8-8afb-4dc1-ab75-7f3592c18c65');
        $d = StringIdentity::create('f571d881-4a16-47bb-9601-8077a629f7a3');

        self::assertFalse($a->isEqual($b));
        self::assertFalse($a->isEqual($c));
        self::assertFalse($b->isEqual($c));

        self::assertTrue($a->isEqual($a));
        self::assertTrue($a->isEqual($d));
    }
}
