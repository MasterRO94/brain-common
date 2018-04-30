<?php

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
     * @throws PrototypeMethodException when updated date is not available.
     *
     * @return DateTimeInterface
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
     *
     * @return bool
     */
    public function hasUpdated(): bool
    {
        return $this->updated instanceof DateTimeInterface;
    }

    /**
     * Set the updated date.
     *
     * @param DateTimeInterface $updated
     */
    public function setUpdated(DateTimeInterface $updated): void
    {
        $this->updated = $updated;
    }
}
