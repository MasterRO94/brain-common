<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Validator\Constraint\Remote;

use Brain\Common\Validator\Constraint\Remote\Checker\RemoteConstraintNotNullChecker;
use Brain\Common\Validator\Constraint\Remote\RemoteConstraint;
use Brain\Common\Validator\Enum\CommonValidatorMessageEnum;

use PHPUnit\Framework\TestCase;

/**
 * @group unit
 * @group common
 * @group validator
 *
 * @covers \Brain\Common\Validator\Constraint\Remote\RemoteConstraint
 */
final class RemoteConstraintTest extends TestCase
{
    /**
     * @test
     */
    public function withFreshConstraintDisabled(): void
    {
        $constraint = new RemoteConstraint();

        self::assertFalse($constraint->isEnabled());
        self::assertEquals(CommonValidatorMessageEnum::MESSAGE_UNKNOWN, $constraint->getMessage());
        self::assertNull($constraint->getChecker());
    }

    /**
     * @test
     */
    public function canEnableConstraint(): void
    {
        $constraint = new RemoteConstraint();
        $constraint->enable('foo-bar', new RemoteConstraintNotNullChecker());

        self::assertTrue($constraint->isEnabled());
        self::assertEquals('foo-bar', $constraint->getMessage());

        self::assertNotNull($constraint->getChecker());
        self::assertInstanceOf(RemoteConstraintNotNullChecker::class, $constraint->getChecker());
    }
}
