<?php

declare(strict_types=1);

namespace Brain\Common\Validator\Constraint\Remote\Checker;

use Brain\Common\Validator\Constraint\Remote\RemoteConstraintCheckerInterface;

/**
 * Check the given value is not null.
 */
final class RemoteConstraintNotNullChecker implements
    RemoteConstraintCheckerInterface
{
    /**
     * {@inheritdoc}
     */
    public function check($value): bool
    {
        return $value !== null;
    }
}
