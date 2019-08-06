<?php

declare(strict_types=1);

namespace Brain\Common\Validator\Constraint\Remote;

use Brain\Common\Validator\Enum\CommonValidatorMessageEnum;

use Symfony\Component\Validator\Constraint;

use Doctrine\Common\Annotations\Annotation;

/**
 * Remote constraint is a way to control validation from another location.
 *
 * The constraint can be passed around and enabled/disabled remotely.
 * When enabling the constraint requires a custom checker to make sure the value is valid.
 * Should it not be valid the constraint message is applied as a violation.
 *
 * @Annotation
 * @Annotation\Target({"CLASS"})
 */
final class RemoteConstraint extends Constraint
{
    /** @var string */
    private $message = CommonValidatorMessageEnum::MESSAGE_UNKNOWN;

    /** @var bool */
    private $state = false;

    /** @var RemoteConstraintCheckerInterface|null */
    private $checker;

    /**
     * {@inheritdoc}
     */
    public function getTargets(): string
    {
        return Constraint::PROPERTY_CONSTRAINT;
    }

    /**
     * Return the constraint message.
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Check if the constraint is enabled.
     */
    public function isEnabled(): bool
    {
        return $this->state;
    }

    /**
     * Return the checker.
     */
    public function getChecker(): ?RemoteConstraintCheckerInterface
    {
        return $this->checker;
    }

    /**
     * Enable the remote constraint.
     *
     * The given error message will be used when failing.
     */
    public function enable(string $message, RemoteConstraintCheckerInterface $checker): void
    {
        $this->state = true;
        $this->message = $message;
        $this->checker = $checker;
    }

    /**
     * Disable the remote constraint.
     */
    public function disable(): void
    {
        $this->state = false;
        $this->message = CommonValidatorMessageEnum::MESSAGE_UNKNOWN;
        $this->checker = null;
    }
}
