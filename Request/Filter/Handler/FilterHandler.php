<?php

namespace Brain\Common\Request\Filter\Handler;

use Brain\Common\Database\Pagination\Adapter\PaginatorQueryBuilderAdapter;
use Brain\Common\Database\Pagination\Paginator;
use Brain\Common\Database\Pagination\PaginatorFactory;
use Brain\Common\Form\Exception\FormHandlerException;
use Brain\Common\Form\Handler\Builder\FormFactory;
use Brain\Common\Request\Filter\Exception\FilterFormValidationException;

use Symfony\Component\HttpFoundation\RequestStack;

use Doctrine\ORM\QueryBuilder;

use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdater;

/**
 * A helper for handling filters and sorts on repository query builders.
 */
final class FilterHandler
{
    private $requestStack;
    private $formFactory;
    private $paginatorFactory;
    private $filterBuilderUpdater;

    /**
     * Constructor.
     *
     * @param RequestStack $requestStack
     * @param FormFactory $formFactory
     * @param PaginatorFactory $paginatorFactory
     * @param FilterBuilderUpdater $filterBuilderUpdater
     */
    public function __construct(
        RequestStack $requestStack,
        FormFactory $formFactory,
        PaginatorFactory $paginatorFactory,
        FilterBuilderUpdater $filterBuilderUpdater
    ) {
        $this->requestStack = $requestStack;
        $this->formFactory = $formFactory;
        $this->paginatorFactory = $paginatorFactory;
        $this->filterBuilderUpdater = $filterBuilderUpdater;
    }

    /**
     * Apply filters to the pagination given.
     *
     * Note the pagination returned is a new paginator and should be used as a
     * replacement for the one provided. The one provided will not have its query modified.
     *
     * @param Paginator $paginator
     * @param string|null $filter
     * @param string|null $sort
     *
     * @return Paginator
     */
    public function filterForPaginator(Paginator $paginator, string $filter = null, string $sort = null): Paginator
    {
        /** @var PaginatorQueryBuilderAdapter $adapter */
        $adapter = $paginator->getAdapter();

        if (!$adapter instanceof PaginatorQueryBuilderAdapter) {
            throw FormHandlerException::createForInvalidPaginatorAdapter();
        }

        $qb = $adapter->getQueryBuilder();

        if (is_string($filter)) {
            $data = $this->getQueryData('filter');
            $qb = $this->applyTypeAndDataForQueryBuilder($qb, $data, $filter);
        }

        if (is_string($sort)) {
            $data = $this->getQueryData('sort');
            $qb = $this->applyTypeAndDataForQueryBuilder($qb, $data, $sort);
        }

        return $this->paginatorFactory->recreateForQueryBuilder($paginator, $qb);
    }

    /**
     * Apply filter sot the query builder given.
     *
     * Note the query builder returned is a new query builder and should be used as a
     * replacement for the one provided. The one provided not have its query modified.
     *
     * @param QueryBuilder $qb
     * @param array $data
     * @param string $type
     *
     * @throws FilterFormValidationException when validation fails.
     *
     * @return QueryBuilder
     */
    public function applyTypeAndDataForQueryBuilder(QueryBuilder $qb, array $data, string $type): QueryBuilder
    {
        if (count($data) === 0) {
            return $qb;
        }

        //  Use the custom form factory to create a nameless form.
        //  Submit our query parameters as data.
        $form = $this->formFactory->createNamedBuilder('', $type)->getForm();
        $form->submit($data, true);

        if (!$form->isValid()) {
            throw new FilterFormValidationException($form);
        }

        /** @var QueryBuilder $qb */
        $qb = $this->filterBuilderUpdater->addFilterConditions($form, $qb);

        return $qb;
    }

    /**
     * Return the filter data.
     *
     * @param string $type
     *
     * @return array
     */
    private function getQueryData(string $type): array
    {
        $request = $this->requestStack->getCurrentRequest();

        /** @var array $data */
        $data = $request->query->get($type, []);

        if (!is_array($data)) {
            return [];
        }

        return $data;
    }
}
