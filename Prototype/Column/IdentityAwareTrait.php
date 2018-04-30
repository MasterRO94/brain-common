<?php

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
     * @throws PrototypeMethodException when the identity is not available.
     *
     * @return int
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
     *
     * @return bool
     */
    public function hasId(): bool
    {
        return is_integer($this->id);
    }
}
