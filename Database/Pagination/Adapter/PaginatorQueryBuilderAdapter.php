<?php

namespace Brain\Common\Database\Pagination\Adapter;

use Doctrine\ORM\QueryBuilder;

use Pagerfanta\Adapter\DoctrineORMAdapter;

/**
 * {@inheritdoc}
 */
final class PaginatorQueryBuilderAdapter extends DoctrineORMAdapter
{
    private $builder;

    /**
     * Constructor.
     *
     * @param QueryBuilder $builder
     * @param bool $fetchJoinCollection
     * @param bool|null $useOutputWalkers
     */
    public function __construct(QueryBuilder $builder, bool $fetchJoinCollection = true, ?bool $useOutputWalkers = null)
    {
        parent::__construct($builder, $fetchJoinCollection, $useOutputWalkers);

        $this->builder = $builder;
    }

    /**
     * Return the query builder used for the paginator.
     *
     * @return QueryBuilder
     */
    public function getQueryBuilder(): QueryBuilder
    {
        return $this->builder;
    }
}
