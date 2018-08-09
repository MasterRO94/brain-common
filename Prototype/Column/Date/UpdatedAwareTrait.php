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
     */
    public function getUpdated(): DateTimeInterface
    {
        if (!$this->hasUpdated()) {
            throw PrototypeMethodException::createForUpdatedDateMissing($this);
        }

        return $this->updated;
    }

    /**
     * Check the updated date.
     */
    public function hasUpdated(): bool
    {
        return $this->updated instanceof DateTimeInterface;
    }

    /**
     * Set the updated date.
     */
    public function setUpdated(DateTimeInterface $updated): void
    {
        $this->updated = $updated;
    }
}
