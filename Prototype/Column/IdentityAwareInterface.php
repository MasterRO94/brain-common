<?php

namespace Brain\Common\Prototype\Column;

use Brain\Common\Exception\Prototype\PrototypeMethodException;

/**
 * Prototype column for unique identity.
 */
interface IdentityAwareInterface
{
    /**
     * Get the identifier.
     *
     * @throws PrototypeMethodException when the identity is not available.
     *
     * @return int
     */
    public function getId(): int;

    /**
     * Check the identifier exists.
     *
     * @return bool
     */
    public function hasId(): bool;
}
