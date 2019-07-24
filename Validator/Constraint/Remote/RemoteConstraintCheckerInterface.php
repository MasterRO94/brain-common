<?php

declare(strict_types=1);

namespace Brain\Common\Validator\Constraint\Remote;

interface RemoteConstraintCheckerInterface
{
    /**
     * Check the given value and return if its considered valid.
     *
     * @param mixed $value
     */
    public function check($value): bool;
}
