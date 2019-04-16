<?php

declare(strict_types=1);

namespace Brain\Common\Database;

use Brain\Common\Authentication\AuthenticationStorageInterface;
use Brain\Common\Database\Pagination\PaginatorFactory;
use Brain\Common\Database\Repository\AbstractEntityRepository;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;

use RuntimeException;

/**
 * A custom database class for handling doctrine.
 */
class Database implements DatabaseInterface
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var PaginatorFactory */
    private $paginatorFactory;

    /** @var AuthenticationStorageInterface */
    private $authenticationStorage;

    public function __construct(
        Registry $registry,
        PaginatorFactory $paginatorFactory,
        AuthenticationStorageInterface $authenticationStorage
    ) {
        /** @var EntityManagerInterface $em */
        $em = $registry->getManager();

        $this->em = $em;
        $this->paginatorFactory = $paginatorFactory;
        $this->authenticationStorage = $authenticationStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityManager(): EntityManagerInterface
    {
        return $this->em;
    }

    /**
     * {@inheritdoc}
     */
    public function getConnection(): Connection
    {
        return $this->em->getConnection();
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository(string $entity): AbstractEntityRepository
    {
        $repository = $this->em->getRepository($entity);

        if ($repository instanceof AbstractEntityRepository) {
            $repository->setPaginatorFactory($this->paginatorFactory);
            $repository->setAuthenticationStorage($this->authenticationStorage);

            return $repository;
        }

        $message = implode(' ', [
            'The entity "%s" should have a repository defined that extends "%s".',
            'Please create this repository and assign it.',
        ]);

        $message = sprintf($message, $entity, AbstractEntityRepository::class);

        throw new RuntimeException($message);
    }
}
