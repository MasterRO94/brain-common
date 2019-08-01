<?php

declare(strict_types=1);

namespace Brain\Common\Prototype\Column\Date\Setup;

use Brain\Common\Date\DateTimeFactoryInterface;
use Brain\Common\Prototype\Column\Date\CreatedAwareInterface;
use Brain\Common\Prototype\Column\Date\DeletedAwareInterface;
use Brain\Common\Prototype\Column\Date\UpdatedAwareInterface;

/**
 * A setup class for date prototypes.
 */
final class DatePrototypeSetup
{
    /** @var DateTimeFactoryInterface */
    private $factory;

    public function __construct(DateTimeFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Setup an instance with date values.
     *
     * @param mixed $instance
     */
    public function setup($instance): void
    {
        $now = $this->factory->createImmutable();

        if ($instance instanceof CreatedAwareInterface) {
            $instance->setCreatedAt($now);
        }

        if ($instance instanceof UpdatedAwareInterface) {
            $instance->setUpdatedAt($now);
        }

        if (!($instance instanceof DeletedAwareInterface)) {
            return;
        }

        $instance->setDeletedAt(null);
    }
}
