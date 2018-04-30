<?php

namespace Brain\Common\Prototype\Column\Date;

use Brain\Common\Exception\Prototype\PrototypeMethodException;

use DateTimeInterface;

/**
 * Prototype column for created date.
 */
trait CreatedAwareTrait
{
    /** @var DateTimeInterface */
    protected $created;

    /**
     * Return the created date.
     *
     * @throws PrototypeMethodException when created date is not available.
     *
     * @return DateTimeInterface
     */
    public function getCreated(): DateTimeInterface
    {
        if (!$this->hasCreated()) {
            throw PrototypeMethodException::createForCreatedDateMissing($this);
        }

        return $this->created;
    }

    /**
     * Check the created date.
     *
     * @return bool
     */
    public function hasCreated(): bool
    {
        return $this->created instanceof DateTimeInterface;
    }

    /**
     * Set the created date.
     *
     * @param DateTimeInterface $created
     */
    public function setCreated(DateTimeInterface $created): void
    {
        $this->created = $created;
    }
}
