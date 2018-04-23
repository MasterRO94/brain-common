<?php

declare(strict_types=1);

namespace Brain\Common\Database\Pagination;

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
    private $requestStack;
    private $page;
    private $limit;

    /**
     * Constructor.
     *
     * @param RequestStack $requestStack
     * @param int $page
     * @param int $limit
     */
    public function __construct(RequestStack $requestStack, int $page, int $limit)
    {
        $this->requestStack = $requestStack;
        $this->page = $page;
        $this->limit = $limit;
    }

    /**
     * Create a paginator for the given adapter.
     *
     * @param AdapterInterface $adapter
     * @param int|null $page
     * @param int|null $limit
     *
     * @throws InvalidPagePaginationException if the "page" in the request is invalid.
     * @throws InvalidLimitPaginationException if the "limit" in the request is invalid.
     *
     * @return Paginator
     */
    public function create(AdapterInterface $adapter, int $page = null, int $limit = null): Paginator
    {
        $request = $this->requestStack->getCurrentRequest();

        $pageRequested = $request->query->get('page', 0);
        if (!is_numeric($pageRequested)) {
            throw new InvalidPagePaginationException();
        }

        $limitRequested = $request->query->get('limit', 0);
        if (!is_numeric($limitRequested)) {
            throw new InvalidLimitPaginationException();
        }

        $paginator = new Paginator($adapter);
        $paginator->setCurrentPage($pageRequested ?: $page ?: $this->page);
        $paginator->setMaxPerPage($limitRequested ?: $limit ?: $this->limit);

        return $paginator;
    }

    /**
     * Create a paginator for the given query builder.
     *
     * @param QueryBuilder $qb
     * @param int|null $page
     * @param int|null $limit
     *
     * @return Paginator
     */
    public function createForQueryBuilder(QueryBuilder $qb, int $page = null, int $limit = null): Paginator
    {
        $adapter = new PaginatorQueryBuilderAdapter($qb);

        return $this->create($adapter, $page, $limit);
    }

    /**
     * Recreate a paginator with a new query builder.
     *
     * @param Paginator $paginator
     * @param QueryBuilder $qb
     *
     * @return Paginator
     */
    public function recreateForQueryBuilder(Paginator $paginator, QueryBuilder $qb): Paginator
    {
        $adapter = new PaginatorQueryBuilderAdapter($qb);

        return $this->create(
            $adapter,
            $paginator->getCurrentPage(),
            $paginator->getMaxPerPage()
        );
    }
}
