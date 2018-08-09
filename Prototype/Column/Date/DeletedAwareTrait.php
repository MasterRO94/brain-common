<?php

declare(strict_types=1);

namespace Brain\Common\Prototype\Column\Date;

use Brain\Common\Exception\Prototype\PrototypeMethodException;

use DateTimeInterface;

/**
 * Prototype column for deleted date.
 */
trait DeletedAwareTrait
{
    /** @var DateTimeInterface */
    protected $deleted;

    /**
     * Return the deleted date.
     *
     * @throws PrototypeMethodException When deleted date is not available.
     */
    public function getDeleted(): ?DateTimeInterface
    {
        if (!$this->hasDeleted()) {
            throw PrototypeMethodException::createForDeletedDateMissing($this);
        }

        return $this->deleted;
    }

    /**
     * Check the deleted date.
     */
    public function hasDeleted(): bool
    {
        return $this->deleted instanceof DateTimeInterface;
    }

    /**
     * Check if deleted.
     */
    public function isDeleted(): bool
    {
        return $this->deleted instanceof DateTimeInterface;
    }

    /**
     * Set the deleted date.
     */
    public function setDeleted(?DateTimeInterface $deleted): void
    {
        $this->deleted = $deleted;
    }
}
