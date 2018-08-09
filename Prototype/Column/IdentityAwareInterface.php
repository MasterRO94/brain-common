<?php

declare(strict_types=1);

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
     * @throws PrototypeMethodException When the identity is not available.
     */
    public function getId(): int;

    /**
     * Check the identifier exists.
     */
    public function hasId(): bool;
}
