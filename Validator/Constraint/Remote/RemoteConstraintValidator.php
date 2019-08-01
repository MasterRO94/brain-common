<?php

declare(strict_types=1);

namespace Brain\Common\Validator\Constraint\Remote;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Remote constraint validator.
 *
 * This validator will check the remote constraint to see if its enabled.
 * If it is enabled it will run the attached checker against the value.
 * Should the checker return false the validator will attach a violation with the message.
 */
final class RemoteConstraintValidator extends ConstraintValidator
{
    /**
     * @param mixed $value
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!($constraint instanceof RemoteConstraint)) {
            throw new UnexpectedTypeException($constraint, RemoteConstraint::class);
        }

        if ($constraint->isEnabled() === false) {
            return;
        }

        $checker = $constraint->getChecker();

        // This needs to be covered for strict typings.
        // But should never happen as enabling the constraint requires a checker.
        if ($checker === null) {
            return;
        }

        if ($checker->check($value) === true) {
            return;
        }

        $this->context
            ->buildViolation($constraint->getMessage())
            ->addViolation();
    }
}
