<?php

declare(strict_types=1);

namespace Brain\Common\Database\Factory;

use Brain\Common\Database\EntityInterface;
use Brain\Common\Prototype\Column\Date\CreatedAwareInterface;
use Brain\Common\Prototype\Column\Date\DeletedAwareInterface;
use Brain\Common\Prototype\Column\Date\UpdatedAwareInterface;

/**
 * This factory implements some functionality based on the database column aware interfaces.
 */
abstract class AbstractDatabaseAwareEntityFactory extends AbstractEntityFactory
{
    /**
     * {@inheritdoc}
     */
    public function prepare(EntityInterface $entity)
    {
        $now = $this->getDateTimeFactory()->create();

        if ($entity instanceof CreatedAwareInterface) {
            $entity->setCreatedAt($now);
        }

        if ($entity instanceof UpdatedAwareInterface) {
            $entity->setUpdatedAt($now);
        }

        if ($entity instanceof DeletedAwareInterface) {
            $entity->setDeletedAt(null);
        }

        return parent::prepare($entity);
    }
}
