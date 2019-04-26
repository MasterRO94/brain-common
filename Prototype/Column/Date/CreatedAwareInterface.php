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
     * @deprecated Use getCreatedAt() instead.
     *
     * @throws PrototypeMethodException When created date is not available.
     */
    public function getCreated(): DateTimeInterface;

    /**
     * Return the created date.
     *
     * @throws PrototypeMethodException When created date is not available.
     */
    public function getCreatedAt(): DateTimeInterface;

    /**
     * Check the created date.
     *
     * @deprecated Use hasCreatedAt() instead.
     */
    public function hasCreated(): bool;

    /**
     * Check the created date.
     */
    public function hasCreatedAt(): bool;

    /**
     * Set the created date.
     *
     * @deprecated Use setCreatedAt() instead.
     */
    public function setCreated(DateTimeInterface $created): void;

    /**
     * Set the created date.
     */
    public function setCreatedAt(DateTimeInterface $created): void;
}
