<?php

namespace Brain\Common\Database\Factory;

use Brain\Common\Database\EntityInterface;
use Brain\Common\Date\DateTimeFactoryInterface;
use Brain\Common\Utility\UniqueIdentityFactoryInterface;

/**
 * An abstract factory for creating instances of entity interface.
 *
 * @api
 */
abstract class AbstractEntityFactory
{
    private $entityClass;
    private $dateTimeFactory;
    private $uniqueIdentityFactory;

    /**
     * Prepare the given entity.
     *
     * @param EntityInterface $entity
     *
     * @return EntityInterface
     *
     * @api
     */
    abstract public function prepare(EntityInterface $entity): EntityInterface;

    /**
     * Constructor.
     *
     * @param string $entityClass
     * @param DateTimeFactoryInterface $dateTimeFactory
     * @param UniqueIdentityFactoryInterface $uniqueIdentityFactory
     */
    public function __construct(
        string $entityClass,
        DateTimeFactoryInterface $dateTimeFactory,
        UniqueIdentityFactoryInterface $uniqueIdentityFactory
    ) {
        $this->entityClass = $entityClass;
        $this->dateTimeFactory = $dateTimeFactory;
        $this->uniqueIdentityFactory = $uniqueIdentityFactory;
    }

    /**
     * Construct an entity from a class name.
     *
     * @return EntityInterface
     */
    final public function construct(): EntityInterface
    {
        $class = $this->entityClass;

        return new $class();
    }

    /**
     * Create and prepare a new instance.
     *
     * @return EntityInterface
     *
     * @api
     */
    public function create(): EntityInterface
    {
        return $this->prepare($this->construct());
    }

    /**
     * Return the date time factory.
     *
     * @return DateTimeFactoryInterface
     */
    final protected function getDateTimeFactory(): DateTimeFactoryInterface
    {
        return $this->dateTimeFactory;
    }

    /**
     * Return the unique identity factory.
     *
     * @return UniqueIdentityFactoryInterface
     */
    final protected function getUniqueIdentityFactory(): UniqueIdentityFactoryInterface
    {
        return $this->uniqueIdentityFactory;
    }
}
