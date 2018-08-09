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
     * @throws PrototypeMethodException When updated date is not available.
     */
    public function getUpdated(): DateTimeInterface;

    /**
     * Check the updated date.
     */
    public function hasUpdated(): bool;

    /**
     * Set the updated date.
     */
    public function setUpdated(DateTimeInterface $updated): void;
}
