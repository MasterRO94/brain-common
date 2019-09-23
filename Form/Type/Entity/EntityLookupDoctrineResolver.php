<?php

declare(strict_types=1);

namespace Brain\Common\Form\Type\Entity;

use Brain\Common\Database\DatabaseInterface;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\QueryBuilder;

class EntityLookupDoctrineResolver
{
    /** @var DatabaseInterface */
    private $database;

    public function __construct(DatabaseInterface $database)
    {
        $this->database = $database;
    }

    /**
     * Handle the lookup and basic validation of the specified entity.
     *
     * @param mixed $data
     * @param EntityLookupDefinition[] $definitions
     *
     * @return mixed
     */
    public function resolve(string $class, $data, array $definitions)
    {
        $qb = $this->getQueryBuilder($class, $data, $definitions);

        if ($qb instanceof QueryBuilder) {
            try {
                return $qb->getQuery()->getOneOrNullResult();
            } catch (NonUniqueResultException $exception) {
                return null;
            }
        }

        return null;
    }

    /**
     * @param mixed $data
     * @param array $definitions
     *
     * @return QueryBuilder|null
     */
    protected function getQueryBuilder(string $class, $data, array $definitions)
    {
        $qb = $this->database->getRepository($class)->createQueryBuilder('e');

        // The expressions will be a series of equality checks against the database.
        // These are build from the entity look up definitions.
        $expressions = [];

        foreach ($definitions as $index => $definition) {
            $value = $data[$index];

            if ($value === null) {
                continue;
            }

            $parameter = sprintf(':%s', $definition->getColumn());
            $qb->setParameter($parameter, $data[$index]);

            $expressions[] = $qb->expr()->eq(sprintf('e.%s', $definition->getColumn()), $parameter);
        }

        // If there are no expressions then the data is all null.
        // In this case the constraints should be triggered so return.
        if (count($expressions) === 0) {
            return null;
        }

        // Apply the expressions to the query builder.
        // Noting that a single expression should be applied on its own outside of an OR block.
        if (count($expressions) > 1) {
            $qb->where($qb->expr()->orX(...$expressions));
        } else {
            $qb->where($expressions[0]);
        }

        return $qb;
    }
}
