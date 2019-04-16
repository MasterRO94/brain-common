<?php

declare(strict_types=1);

namespace Brain\Common\Database\Pagination\Adapter;

use Doctrine\ORM\QueryBuilder;

use Pagerfanta\Adapter\DoctrineORMAdapter;

/**
 * {@inheritdoc}
 */
final class PaginatorQueryBuilderAdapter extends DoctrineORMAdapter
{
    /** @var QueryBuilder */
    private $builder;

    public function __construct(QueryBuilder $builder, bool $fetchJoinCollection, ?bool $useOutputWalkers)
    {
        parent::__construct($builder, $fetchJoinCollection, $useOutputWalkers);

        $this->builder = $builder;
    }

    /**
     * Return the query builder used for the paginator.
     */
    public function getQueryBuilder(): QueryBuilder
    {
        return $this->builder;
    }
}
