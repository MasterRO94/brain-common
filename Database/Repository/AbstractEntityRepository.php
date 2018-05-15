<?php

namespace Brain\Common\Database\Repository;

use Brain\Common\Authentication\AuthenticationStorageInterface;
use Brain\Common\Database\Exception\EntityRepositoryException;
use Brain\Common\Database\Pagination\Paginator;
use Brain\Common\Database\Pagination\PaginatorFactory;

use Doctrine\ORM\EntityRepository;

/**
 * An enhanced doctrine repository.
 *
 * @api
 */
abstract class AbstractEntityRepository extends EntityRepository
{
    const SORT_ASC = 'ASC';
    const SORT_DESC = 'DESC';

    /** @var PaginatorFactory */
    private $paginatorFactory;

    /** @var AuthenticationStorageInterface */
    private $authenticationStorage;

    /**
     * Set the paginator helper factory.
     *
     * @param PaginatorFactory $paginatorFactory
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
     * @param AuthenticationStorageInterface $authenticationStorage
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
     *
     * @return PaginatorFactory
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
     *
     * @return AuthenticationStorageInterface
     */
    protected function getAuthenticationStorage(): AuthenticationStorageInterface
    {
        if (!$this->authenticationStorage instanceof AuthenticationStorageInterface) {
            throw EntityRepositoryException::createForMissingAuthenticationStorage();
        }

        return $this->authenticationStorage;
    }
}
