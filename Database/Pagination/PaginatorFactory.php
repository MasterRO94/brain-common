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
     * @return Paginator
     *
     * @throws InvalidPagePaginationException if the "page" in the request is invalid.
     * @throws InvalidLimitPaginationException if the "limit" in the request is invalid.
     */
    public function create(AdapterInterface $adapter, int $page = null, int $limit = null): Paginator
    {
        $page = $this->getRequestPageParameter() ?? $page ?? $this->page;
        $limit = $this->getRequestLimitParameter() ?? $limit ?? $this->limit;

        $paginator = new Paginator($adapter);
        $paginator->setCurrentPage($page);
        $paginator->setMaxPerPage($limit);

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

    /**
     * Return the request page parameter.
     *
     * @return int|null
     *
     * @throws InvalidPagePaginationException if the "page" in the request is invalid.
     */
    private function getRequestPageParameter(): ?int
    {
        $request = $this->requestStack->getCurrentRequest();

        //  Console commands do not have requests, so defer to defaults.
        if ($request === null) {
            return null;
        }

        //  &page=10
        $page = $request->query->get('page', null);

        if (is_numeric($page)) {
            return (int) $page;
        }

        throw new InvalidPagePaginationException();
    }

    /**
     * Return the request limit parameter.
     *
     * @return int|null
     *
     * @throws InvalidLimitPaginationException if the "limit" in the request is invalid.
     */
    private function getRequestLimitParameter(): ?int
    {
        $request = $this->requestStack->getCurrentRequest();

        //  Console commands do not have requests, so defer to defaults.
        if ($request === null) {
            return null;
        }

        //  &limit=40
        $limit = $request->query->get('limit', null);

        if (is_numeric($limit)) {
            return (int) $limit;
        }

        throw new InvalidLimitPaginationException();
    }
}
