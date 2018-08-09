<?php

declare(strict_types=1);

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
     * @throws PrototypeMethodException When created date is not available.
     */
    public function getCreated(): DateTimeInterface;

    /**
     * Check the created date.
     */
    public function hasCreated(): bool;

    /**
     * Set the created date.
     */
    public function setCreated(DateTimeInterface $created): void;
}
