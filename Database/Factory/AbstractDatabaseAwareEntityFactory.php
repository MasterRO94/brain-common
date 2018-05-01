<?php

namespace Brain\Common\Database\Factory;

use Brain\Common\Database\EntityInterface;
use Brain\Common\Prototype\Column\Date\CreatedAwareInterface;
use Brain\Common\Prototype\Column\Date\DeletedAwareInterface;
use Brain\Common\Prototype\Column\Date\UpdatedAwareInterface;

/**
 * {@inheritdoc}
 *
 * This factory implements some functionality based on the database column aware interfaces.
 */
abstract class AbstractDatabaseAwareEntityFactory extends AbstractEntityFactory
{
    /**
     * {@inheritdoc}
     */
    public function prepare(EntityInterface $entity): EntityInterface
    {
        $now = $this->getDateTimeFactory()->create();

        if ($entity instanceof CreatedAwareInterface) {
            $entity->setCreated($now);
        }

        if ($entity instanceof UpdatedAwareInterface) {
            $entity->setUpdated($now);
        }

        if ($entity instanceof DeletedAwareInterface) {
            $entity->setDeleted(null);
        }

        return $entity;
    }
}