<?php

namespace Brain\Common\Database\Pagination;

use Pagerfanta\Pagerfanta;

/**
 * {@inheritdoc}
 */
final class Paginator extends Pagerfanta
{
    /**
     * The total count of results available without pagination.
     */
    const PAGINATION_RESULTS_TOTAL = 'Pagination-Results-Total';

    /**
     * The result set total count, this will always be less or equal to the limit.
     */
    const PAGINATION_RESULTS = 'Pagination-Results';

    /**
     * The result limit.
     */
    const PAGINATION_RESULTS_PER_PAGE = 'Pagination-Results-Per-Page';

    /**
     * The total page count.
     */
    const PAGINATION_PAGE_TOTAL = 'Pagination-Pages-Total';
}
