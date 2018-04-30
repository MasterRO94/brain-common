<?php

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
     * @throws PrototypeMethodException when deleted date is not available.
     *
     * @return DateTimeInterface|null
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
     *
     * @return bool
     */
    public function hasDeleted(): bool
    {
        return $this->deleted instanceof DateTimeInterface;
    }

    /**
     * Check if deleted.
     *
     * @return bool
     */
    public function isDeleted(): bool
    {
        return $this->deleted instanceof DateTimeInterface;
    }

    /**
     * Set the deleted date.
     *
     * @param DateTimeInterface $deleted
     */
    public function setDeleted(?DateTimeInterface $deleted): void
    {
        $this->deleted = $deleted;
    }
}
