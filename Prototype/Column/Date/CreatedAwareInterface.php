<?php

namespace Brain\Common\Prototype\Column\Date;

use Brain\Common\Exception\Prototype\PrototypeMethodException;

use DateTimeInterface;

/**
 * Prototype column for created date.
 */
interface CreatedAwareInterface
{
    /**
     * Return the created date.
     *
     * @throws PrototypeMethodException when created date is not available.
     *
     * @return DateTimeInterface
     */
    public function getCreated(): DateTimeInterface;

    /**
     * Check the created date.
     *
     * @return bool
     */
    public function hasCreated(): bool;

    /**
     * Set the created date.
     *
     * @param DateTimeInterface $created
     */
    public function setCreated(DateTimeInterface $created): void;
}
