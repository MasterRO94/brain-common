<?php

declare(strict_types=1);

namespace Brain\Common\Form\Type\Entity;

use Brain\Common\Database\DatabaseInterface;

use Doctrine\ORM\QueryBuilder;

final class FilterableEntityLookupDoctrineResolver extends EntityLookupDoctrineResolver
{
    /** @var array */
    private $filter;

    public function __construct(DatabaseInterface $database, array $filter)
    {
        parent::__construct($database);
        $this->filter = $filter;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryBuilder(string $class, $data, array $definitions)
    {
        $qb = parent::getQueryBuilder($class, $data, $definitions);

        if ($qb instanceof QueryBuilder) {
            foreach ($this->filter as $column => $value) {
                $qb->andWhere($qb->expr()->eq('e.' . $column, ':' . $column));
                $qb->setParameter($column, $value);
            }
        }

        return $qb;
    }
}
