<?php

declare(strict_types=1);

namespace Brain\Common\Request\Filter\Handler;

use Brain\Common\Database\Pagination\Paginator;
use Brain\Common\Request\Filter\Exception\FilterFormValidationException;

use Doctrine\ORM\QueryBuilder;

interface FilterHandlerInterface
{
    /**
     * Apply filters to the pagination given.
     */
    public function filterForPaginator(Paginator $paginator, ?string $filter = null, ?string $sort = null): Paginator;

    /**
     * Apply filter sot the query builder given.
     *
     * @param mixed[] $data
     *
     * @throws FilterFormValidationException When validation fails.
     */
    public function applyTypeAndDataForQueryBuilder(QueryBuilder $qb, array $data, string $type): QueryBuilder;
}
