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

    /**
     * Set the current page to the next page.
     */
    public function next(): bool
    {
        if (($this->getCurrentPage() + 1) > $this->getNbPages()) {
            return false;
        }

        $page = $this->getCurrentPage();
        $this->setCurrentPage($page + 1);

        if ($page === $this->getCurrentPage()) {
            throw new \RuntimeException(implode(' ', [
                'For some unknown reason we cannot progress past the current page.',
                'To debug this prepare coffee and sit in a padded room.',
                'Trust me.',
            ]));
        }

        return true;
    }

    /**
     * Return the paginator results.
     *
     * @return mixed[]
     */
    public function getData(): array
    {
        /** @var \Traversable $traversable */
        $traversable = $this->getIterator();

        if ($traversable instanceof \Traversable) {
            return iterator_to_array($traversable);
        }

        return (array) $traversable;
    }
}
