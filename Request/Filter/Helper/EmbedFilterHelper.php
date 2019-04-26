<?php

declare(strict_types=1);

namespace Brain\Common\Request\Filter\Helper;

use Doctrine\ORM\QueryBuilder;

use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderExecuterInterface;

/**
 * A embedded filter helper.
 */
final class EmbedFilterHelper
{
    /**
     * Return a simplified embed closure.
     */
    public static function embed(string $name, string $column): callable
    {
        return static function (FilterBuilderExecuterInterface $qbe) use ($name, $column): void {
            // We generate a field name that the bundle expects.
            // This is actually the wrong field name and is a combination of the alias and the form name.
            // Example "material.base" where the join is actually "material.stockMaterialBase".
            // We handle the proper field name in the next closure.
            $field = FilterDatabaseHelper::generateFieldName($qbe->getAlias(), $name);

            $qbe->addOnce($field, $name, static function (QueryBuilder $qb, $alias, $joinAlias) use ($column): void {
                // This is the legit doctrine join field.
                $field = FilterDatabaseHelper::generateFieldName($alias, $column);
                $qb->join($field, $joinAlias);
            });
        };
    }
}
