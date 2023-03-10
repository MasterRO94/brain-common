<?php

declare(strict_types=1);

namespace Brain\Common\Database\Pagination;

use Brain\Common\Database\Exception\Paginator\CannotUseSpecialisedPaginationException;
use Brain\Common\Database\Exception\Paginator\InvalidLimitPaginationException;
use Brain\Common\Database\Exception\Paginator\InvalidPagePaginationException;
use Brain\Common\Database\Pagination\Adapter\PaginatorQueryBuilderAdapter;

use Symfony\Component\HttpFoundation\RequestStack;

use Doctrine\ORM\QueryBuilder;

use Pagerfanta\Adapter\AdapterInterface;

/**
 * A paginator factory.
 */
final class PaginatorFactory
{
    /** @var RequestStack */
    private $requestStack;

    /** @var int */
    private $page;

    /** @var int */
    private $limit;

    public function __construct(RequestStack $requestStack, int $page, int $limit)
    {
        $this->requestStack = $requestStack;
        $this->page = $page;
        $this->limit = $limit;
    }

    /**
     * Create a paginator for the given adapter.
     *
     * @throws InvalidPagePaginationException When the "page" in the request is invalid.
     * @throws InvalidLimitPaginationException When the "limit" in the request is invalid.
     */
    public function create(AdapterInterface $adapter, ?int $page = null, ?int $limit = null): Paginator
    {
        $page = $page ?? $this->getRequestPageParameter() ??  $this->page;
        $limit = $limit ?? $this->getRequestLimitParameter() ?? $this->limit;

        $paginator = new Paginator($adapter);
        $paginator->setMaxPerPage($limit);
        $paginator->setCurrentPage($page);

        return $paginator;
    }

    /**
     * Create a specialised paginator that does not attempt to remove duplicate entries
     * from the query. This query cannot be used if the query detects a JOIN usage.
     */
    public function createForQueryBuilderSpecialised(QueryBuilder $qb, ?int $page = null, ?int $limit = null): Paginator
    {
        $joins = $qb->getDQLPart('join');

        if (count($joins) > 0) {
            throw CannotUseSpecialisedPaginationException::create();
        }

        $adapter = new PaginatorQueryBuilderAdapter($qb, false, true);

        return $this->create($adapter, $page, $limit);
    }

    /**
     * Create a paginator for the given query builder.
     */
    public function createForQueryBuilder(QueryBuilder $qb, ?int $page = null, ?int $limit = null): Paginator
    {
        $adapter = new PaginatorQueryBuilderAdapter($qb, true, null);

        return $this->create($adapter, $page, $limit);
    }

    /**
     * Recreate a paginator with a new query builder.
     */
    public function recreateForQueryBuilder(Paginator $paginator, QueryBuilder $qb): Paginator
    {
        /** @var PaginatorQueryBuilderAdapter $adapter */
        $adapter = $paginator->getAdapter();
        $adapter = new PaginatorQueryBuilderAdapter($qb, $adapter->getFetchJoinCollection(), null);

        return $this->create(
            $adapter,
            $paginator->getCurrentPage(),
            $paginator->getMaxPerPage()
        );
    }

    /**
     * Return the request page parameter.
     *
     * @throws InvalidPagePaginationException When the "page" in the request is invalid.
     */
    private function getRequestPageParameter(): ?int
    {
        $request = $this->requestStack->getCurrentRequest();

        // Console commands do not have requests, so defer to defaults.
        if ($request === null) {
            return null;
        }

        // &page=10
        $page = $request->query->get('page', null);

        if ($page === null) {
            return null;
        }

        if (is_numeric($page)) {
            return (int) $page;
        }

        throw new InvalidPagePaginationException();
    }

    /**
     * Return the request limit parameter.
     *
     * @throws InvalidLimitPaginationException When the "limit" in the request is invalid.
     */
    private function getRequestLimitParameter(): ?int
    {
        $request = $this->requestStack->getCurrentRequest();

        // Console commands do not have requests, so defer to defaults.
        if ($request === null) {
            return null;
        }

        // &limit=40
        $limit = $request->query->get('limit', null);

        if ($limit === null) {
            return null;
        }

        if (is_numeric($limit)) {
            return (int) $limit;
        }

        throw new InvalidLimitPaginationException();
    }
}
