<?php

namespace Brain\Common\Database;

use Brain\Common\Authentication\AuthenticationStorageInterface;
use Brain\Common\Database\Pagination\PaginatorFactory;
use Brain\Common\Database\Repository\AbstractEntityRepository;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

/**
 * A custom database class for handling doctrine.
 *
 * @api
 */
class Database
{
    /** @var EntityManagerInterface */
    private $em;
    private $paginatorFactory;
    private $authenticationStorage;

    /**
     * Constructor.
     *
     * @param Registry $registry
     * @param PaginatorFactory $paginatorFactory
     * @param AuthenticationStorageInterface $authenticationStorage
     */
    public function __construct(
        Registry $registry,
        PaginatorFactory $paginatorFactory,
        AuthenticationStorageInterface $authenticationStorage
    ) {
        $this->em = $registry->getManager();
        $this->paginatorFactory = $paginatorFactory;
        $this->authenticationStorage = $authenticationStorage;
    }

    /**
     * Return the doctrine entity manager.
     *
     * @return EntityManagerInterface
     */
    final public function getEntityManager(): EntityManagerInterface
    {
        return $this->em;
    }

    /**
     * Return the doctrine connection.
     *
     * @return Connection
     */
    final public function getConnection(): Connection
    {
        return $this->em->getConnection();
    }

    /**
     * Return the entity repository for the given entity.
     *
     * @param string $entity
     *
     * @return AbstractEntityRepository
     *
     * @api
     */
    public function getRepository(string $entity): AbstractEntityRepository
    {
        /** @var AbstractEntityRepository $repository */
        $repository = $this->em->getRepository($entity);

        if ($repository instanceof AbstractEntityRepository) {
            $repository->setPaginatorFactory($this->paginatorFactory);
            $repository->setAuthenticationStorage($this->authenticationStorage);
        }

        return $repository;
    }
}
