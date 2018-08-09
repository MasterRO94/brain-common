<?php

declare(strict_types=1);

namespace Brain\Common\Prototype\Column;

use Brain\Common\Exception\Prototype\PrototypeMethodException;

/**
 * Prototype column for unique identity.
 */
trait IdentityAwareTrait
{
    /** @var int */
    protected $id;

    /**
     * Get the identifier.
     *
     * @throws PrototypeMethodException When the identity is not available.
     */
    public function getId(): int
    {
        if (!$this->hasId()) {
            throw PrototypeMethodException::createForIdentityMissing($this);
        }

        return $this->id;
    }

    /**
     * Check the identifier exists.
     */
    public function hasId(): bool
    {
        return is_int($this->id);
    }
}
