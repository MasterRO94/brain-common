<?php

namespace Brain\Common\Request\Filter\Helper;

/**
 * A small helper for database related code in filters.
 */
final class FilterDatabaseHelper
{
    /**
     * Generate a filter alias name that is unique.
     *
     * @param string $field
     *
     * @return string
     */
    public static function generateParameterName(string $field): string
    {
        $a = str_replace(['.', '-', '_'], ' ', $field);
        $b = ucwords($a);
        $c = str_replace(' ', '', $b);

        return sprintf('filter_%s_%s', $c, uniqid());
    }

    /**
     * Generate a field name.
     *
     * @param string|null $prefix
     * @param string $column
     *
     * @return string
     */
    public static function generateFieldName(?string $prefix, string $column): string
    {
        return (bool) $prefix
            ? sprintf('%s.%s', $prefix, $column)
            : $column;
    }

    /**
     * Return the alias from a column name.
     *
     * @param string $column
     *
     * @return string
     */
    public static function getAliasFromColumn(string $column): string
    {
        $parts = explode('.', $column);

        return $parts[0];
    }
}
