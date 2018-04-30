<?php

namespace Brain\Common\Prototype\Column\Date;

use Brain\Common\Exception\Prototype\PrototypeMethodException;

use DateTimeInterface;

/**
 * Prototype column for updated date.
 */
interface UpdatedAwareInterface
{
    /**
     * Return the updated date.
     *
     * @throws PrototypeMethodException when updated date is not available.
     *
     * @return DateTimeInterface
     */
    public function getUpdated(): DateTimeInterface;

    /**
     * Check the updated date.
     *
     * @return bool
     */
    public function hasUpdated(): bool;

    /**
     * Set the updated date.
     *
     * @param DateTimeInterface $updated
     */
    public function setUpdated(DateTimeInterface $updated): void;
}
