<?php

declare(strict_types=1);

namespace Brain\Common\Database\Query\Helper;

use Brain\Common\Type\StringTypeHelper;

final class DatabaseQueryHelper
{
    /**
     * Return a placeholder value that will not cause issue with SQL.
     */
    public static function placeholder(): string
    {
        return 'TRUE -- IGNORE';
    }

    /**
     * Create a string list (comma-separated) from the given int[].
     *
     * @param int[] $array
     */
    public static function list(array $array): string
    {
        return implode(', ', $array);
    }

    /**
     * Breakout a comma-separated string to an array of integers.
     *
     * Currently this assumes you are giving a correct input.
     * However this does need to change to valid or remove non-integer values.
     *
     * @return int[]
     */
    public static function ids(string $string): array
    {
        $exploded = explode(',', $string);

        /** @var int[] $output */
        $output = array_map([StringTypeHelper::class, 'toInteger'], $exploded);

        return $output;
    }

    /**
     * Replace template parameters with data.
     *
     * @param mixed[] $input
     */
    public static function template(string $template, array $input): string
    {
        $parameters = [];

        foreach ($input as $key => $value) {
            $parameters[sprintf(':%s', $key)] = $value;
        }

        return strtr($template, $parameters);
    }
}
