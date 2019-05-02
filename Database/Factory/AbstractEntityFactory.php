<?php

declare(strict_types=1);

namespace Brain\Common\Database\Factory;

use Brain\Common\Database\EntityInterface;
use Brain\Common\Date\DateTimeFactoryInterface;
use Brain\Common\Utility\UniqueIdentityFactoryInterface;

/**
 * An abstract factory for creating instances of entity interface.
 */
abstract class AbstractEntityFactory
{
    /** @var string */
    private $entityClass;

    /** @var DateTimeFactoryInterface */
    private $dateTimeFactory;

    /** @var UniqueIdentityFactoryInterface */
    private $uniqueIdentityFactory;

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
     * @return mixed
     */
    public function construct()
    {
        $class = $this->entityClass;

        return new $class();
    }

    /**
     * Create and prepare a new instance.
     *
     * @return mixed
     */
    public function create()
    {
        return $this->prepare($this->construct());
    }

    /**
     * Prepare the given entity.
     *
     * @return mixed
     */
    public function prepare(EntityInterface $entity)
    {
        return $entity;
    }

    /**
     * Return the date time factory.
     */
    final protected function getDateTimeFactory(): DateTimeFactoryInterface
    {
        return $this->dateTimeFactory;
    }

    /**
     * Return the unique identity factory.
     */
    final protected function getUniqueIdentityFactory(): UniqueIdentityFactoryInterface
    {
        return $this->uniqueIdentityFactory;
    }
}
