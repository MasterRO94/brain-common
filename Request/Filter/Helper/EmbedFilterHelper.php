<?php

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
     *
     * @param string $name
     * @param string $column
     *
     * @return callable
     */
    public static function embed(string $name, string $column): callable
    {
        return function (FilterBuilderExecuterInterface $qbe) use ($name, $column) {
            //  We generate a field name that the bundle expects.
            //  This is actually the wrong field name and is a combination of the alias and the form name.
            //    Example "material.base" where the join is actually "material.stockMaterialBase".
            //  We handle the proper field name in the next closure.
            $field = FilterDatabaseHelper::generateFieldName($qbe->getAlias(), $name);

            $qbe->addOnce($field, $name, function (QueryBuilder $qb, $alias, $joinAlias) use ($column) {
                //  This is the legit doctrine join field.
                $field = FilterDatabaseHelper::generateFieldName($alias, $column);
                $qb->join($field, $joinAlias);
            });
        };
    }
}
