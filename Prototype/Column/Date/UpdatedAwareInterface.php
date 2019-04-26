<?php

declare(strict_types=1);

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
     * @deprecated Use getUpdatedAt() instead.
     *
     * @throws PrototypeMethodException When updated date is not available.
     */
    public function getUpdated(): DateTimeInterface;

    /**
     * Return the updated date.
     *
     * @throws PrototypeMethodException When updated date is not available.
     */
    public function getUpdatedAt(): DateTimeInterface;

    /**
     * Check the updated date.
     *
     * @deprecated Use hasUpdatedAt() instead.
     */
    public function hasUpdated(): bool;

    /**
     * Check the updated date.
     */
    public function hasUpdatedAt(): bool;

    /**
     * Set the updated date.
     *
     * @deprecated Use setUpdatedAt() instead.
     */
    public function setUpdated(DateTimeInterface $updated): void;

    /**
     * Set the updated date.
     */
    public function setUpdatedAt(DateTimeInterface $updated): void;
}
