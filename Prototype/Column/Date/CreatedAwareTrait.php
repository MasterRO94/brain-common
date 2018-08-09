<?php

declare(strict_types=1);

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
     * @throws PrototypeMethodException When created date is not available.
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
     */
    public function hasCreated(): bool
    {
        return $this->created instanceof DateTimeInterface;
    }

    /**
     * Set the created date.
     */
    public function setCreated(DateTimeInterface $created): void
    {
        $this->created = $created;
    }
}
