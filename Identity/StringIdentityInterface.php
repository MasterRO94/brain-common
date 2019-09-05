<?php

declare(strict_types=1);

namespace Brain\Common\Identity;

use Brain\Common\Representation\Type\StringRepresentationInterface;

/**
 * A string identity.
 */
interface StringIdentityInterface extends
    StringRepresentationInterface
{
    /**
     * Check identities are equal.
     */
    public function isEqual(StringIdentityInterface $comparison): bool;
}
