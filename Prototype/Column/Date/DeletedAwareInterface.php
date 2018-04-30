<?php

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
     *
     * @return DateTimeInterface|null
     */
    public function getDeleted(): ?DateTimeInterface;

    /**
     * Check the deleted date.
     *
     * @return bool
     */
    public function hasDeleted(): bool;

    /**
     * Check if deleted.
     *
     * @return bool
     */
    public function isDeleted(): bool;

    /**
     * Set the deletion date.
     *
     * This can be set to null assuming the instance has not been deleted or is being retored.
     *
     * @param DateTimeInterface|null $deletion
     */
    public function setDeleted(?DateTimeInterface $deletion): void;
}
