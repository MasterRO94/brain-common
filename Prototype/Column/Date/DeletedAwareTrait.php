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
     *
     * @deprecated Use getDeletedAt() instead.
     */
    public function getDeleted(): ?DateTimeInterface
    {
        return $this->getDeletedAt();
    }

    /**
     * Return the deleted date.
     *
     * @throws PrototypeMethodException When deleted date is not available.
     */
    public function getDeletedAt(): ?DateTimeInterface
    {
        if (!$this->hasDeleted()) {
            throw PrototypeMethodException::createForDeletedDateMissing($this);
        }

        return $this->deleted;
    }

    /**
     * Check the deleted date.
     *
     * @deprecated Use hasDeletedAt() instead.
     */
    public function hasDeleted(): bool
    {
        return $this->hasDeletedAt();
    }

    /**
     * Check the deleted date.
     */
    public function hasDeletedAt(): bool
    {
        return $this->deleted instanceof DateTimeInterface;
    }

    /**
     * Check if deleted.
     */
    public function isDeleted(): bool
    {
        return $this->hasDeletedAt();
    }

    /**
     * Set the deleted date.
     *
     * @deprecated Use setDeletedAt() instead.
     */
    public function setDeleted(?DateTimeInterface $deleted): void
    {
        $this->setDeletedAt($deleted);
    }

    /**
     * Set the deleted date.
     */
    public function setDeletedAt(?DateTimeInterface $deleted): void
    {
        $this->deleted = $deleted;
    }
}
