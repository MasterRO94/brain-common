<?php

declare(strict_types=1);

namespace Brain\Common\Tests\Unit\Validator\Constraint\Remote;

use Brain\Common\Validator\Constraint\Remote\Checker\RemoteConstraintNotNullChecker;
use Brain\Common\Validator\Constraint\Remote\RemoteConstraint;
use Brain\Common\Validator\Constraint\Remote\RemoteConstraintValidator;

use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * @group unit
 * @group common
 * @group validator
 *
 * @covers \Brain\Common\Validator\Constraint\Remote\RemoteConstraintValidator
 */
final class RemoteConstraintValidatorTest extends TestCase
{
    /**
     * @test
     */
    public function withFreshConstraintValidatorDoesNothing(): void
    {
        $constraint = new RemoteConstraint();

        /** @var ExecutionContextInterface|MockObject $context */
        $context = $this->createMock(ExecutionContextInterface::class);
        $context->expects(self::never())
            ->method('buildViolation');

        $validator = new RemoteConstraintValidator();
        $validator->initialize($context);
        $validator->validate(null, $constraint);
    }

    /**
     * @test
     */
    public function withConstraintEnabledCheckValidDoesNothing(): void
    {
        $constraint = new RemoteConstraint();
        $constraint->enable('foo', new RemoteConstraintNotNullChecker());

        /** @var ExecutionContextInterface|MockObject $context */
        $context = $this->createMock(ExecutionContextInterface::class);
        $context->expects(self::never())
            ->method('buildViolation');

        $validator = new RemoteConstraintValidator();
        $validator->initialize($context);
        $validator->validate('example-string', $constraint);
    }

    /**
     * @test
     */
    public function whenCheckerFailsAddViolation(): void
    {
        $constraint = new RemoteConstraint();
        $constraint->enable('foo-bar', new RemoteConstraintNotNullChecker());

        /** @var ConstraintViolationBuilderInterface|MockObject $builder */
        $builder = $this->createMock(ConstraintViolationBuilderInterface::class);
        $builder->expects(self::once())
            ->method('addViolation');

        /** @var ExecutionContextInterface|MockObject $context */
        $context = $this->createMock(ExecutionContextInterface::class);
        $context->expects(self::once())
            ->method('buildViolation')
            ->with('foo-bar')
            ->willReturn($builder);

        $validator = new RemoteConstraintValidator();
        $validator->initialize($context);
        $validator->validate(null, $constraint);
    }
}
