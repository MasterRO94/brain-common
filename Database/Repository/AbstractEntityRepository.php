<?php

declare(strict_types=1);

namespace Brain\Common\Database\Repository;

use Brain\Common\Authentication\AuthenticationStorageInterface;
use Brain\Common\Database\Exception\EntityRepositoryException;
use Brain\Common\Database\Pagination\Paginator;
use Brain\Common\Database\Pagination\PaginatorFactory;

use Doctrine\ORM\EntityRepository;

/**
 * An enhanced doctrine repository.
 */
abstract class AbstractEntityRepository extends EntityRepository
{
    public const SORT_ASC = 'ASC';
    public const SORT_DESC = 'DESC';

    /** @var PaginatorFactory */
    private $paginatorFactory;

    /** @var AuthenticationStorageInterface */
    private $authenticationStorage;

    /**
     * Set the paginator helper factory.
     *
     * @internal This should only be called through the database helper.
     */
    final public function setPaginatorFactory(PaginatorFactory $paginatorFactory): void
    {
        $this->paginatorFactory = $paginatorFactory;
    }

    /**
     * Set the authentication storage helper.
     *
     * @internal This should only be called through the database helper.
     */
    final public function setAuthenticationStorage(AuthenticationStorageInterface $authenticationStorage): void
    {
        $this->authenticationStorage = $authenticationStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function paginateAll(): Paginator
    {
        $qb = $this->createQueryBuilder('entity');
        $qb->select('entity');

        return $this->getPaginatorFactory()->createForQueryBuilder($qb);
    }

    /**
     * Return the paginator factory helper.
     */
    protected function getPaginatorFactory(): PaginatorFactory
    {
        if (!$this->paginatorFactory instanceof PaginatorFactory) {
            throw EntityRepositoryException::createForMissingPaginationFactory();
        }

        return $this->paginatorFactory;
    }

    /**
     * Return the authentication storage.
     */
    protected function getAuthenticationStorage(): AuthenticationStorageInterface
    {
        if (!$this->authenticationStorage instanceof AuthenticationStorageInterface) {
            throw EntityRepositoryException::createForMissingAuthenticationStorage();
        }

        return $this->authenticationStorage;
    }
}
