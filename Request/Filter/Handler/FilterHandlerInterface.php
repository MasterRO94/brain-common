<?php

namespace Brain\Common\Request\Filter\Handler;

use Brain\Common\Database\Pagination\Paginator;
use Brain\Common\Request\Filter\Exception\FilterFormValidationException;

use Doctrine\ORM\QueryBuilder;

interface FilterHandlerInterface
{
    /**
     * Apply filters to the pagination given.
     *
     * @param Paginator $paginator
     * @param string|null $filter
     * @param string|null $sort
     *
     * @return Paginator
     */
    public function filterForPaginator(Paginator $paginator, string $filter = null, string $sort = null): Paginator;

    /**
     * Apply filter sot the query builder given.
     *
     * @param QueryBuilder $qb
     * @param array $data
     * @param string $type
     *
     * @throws FilterFormValidationException when validation fails.
     *
     * @return QueryBuilder
     */
    public function applyTypeAndDataForQueryBuilder(QueryBuilder $qb, array $data, string $type): QueryBuilder;
}
