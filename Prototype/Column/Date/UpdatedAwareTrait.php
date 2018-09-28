<?php

declare(strict_types=1);

namespace Brain\Common\Prototype\Column\Date;

use Brain\Common\Exception\Prototype\PrototypeMethodException;

use DateTimeInterface;

/**
 * Prototype column for updated date.
 */
trait UpdatedAwareTrait
{
    /** @var DateTimeInterface */
    protected $updated;

    /**
     * Return the updated date.
     *
     * @throws PrototypeMethodException When updated date is not available.
     *
     * @deprecated Use getUpdatedAt() instead.
     */
    public function getUpdated(): DateTimeInterface
    {
        return $this->getUpdatedAt();
    }

    /**
     * Return the updated date.
     *
     * @throws PrototypeMethodException When updated date is not available.
     */
    public function getUpdatedAt(): DateTimeInterface
    {
        if (!$this->hasUpdatedAt()) {
            throw PrototypeMethodException::createForUpdatedDateMissing($this);
        }

        return $this->updated;
    }

    /**
     * Check the updated date.
     *
     * @deprecated Use hasUpdatedAt() instead.
     */
    public function hasUpdated(): bool
    {
        return $this->hasUpdatedAt();
    }

    /**
     * Check the updated date.
     */
    public function hasUpdatedAt(): bool
    {
        return $this->updated instanceof DateTimeInterface;
    }

    /**
     * Set the updated date.
     *
     * @deprecated Use setUpdatedAt() instead.
     */
    public function setUpdated(DateTimeInterface $updated): void
    {
        $this->setUpdatedAt($updated);
    }

    /**
     * Set the updated date.
     */
    public function setUpdatedAt(DateTimeInterface $updated): void
    {
        $this->updated = $updated;
    }
}
