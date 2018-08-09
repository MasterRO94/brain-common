<?php

declare(strict_types=1);

namespace Brain\Common\Prototype\Column\Date;

use DateTimeInterface;

/**
 * Prototype column for deleted date.
 */
interface DeletedAwareInterface
{
    /**
     * Return the deletion date.
     *
     * This can return null if the attached instance has not been deleted.
     */
    public function getDeleted(): ?DateTimeInterface;

    /**
     * Check the deleted date.
     */
    public function hasDeleted(): bool;

    /**
     * Check if deleted.
     */
    public function isDeleted(): bool;

    /**
     * Set the deletion date.
     *
     * This can be set to null assuming the instance has not been deleted or is being retored.
     */
    public function setDeleted(?DateTimeInterface $deletion): void;
}
