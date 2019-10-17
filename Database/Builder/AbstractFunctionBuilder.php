<?php

declare(strict_types=1);

namespace Brain\Common\Database\Builder;

/**
 * An abstract function definition.
 */
abstract class AbstractFunctionBuilder
{
    /**
     * Return the name of the function.
     */
    abstract public static function getFunctionName(): string;

    /**
     * Return the arguments for the function.
     */
    abstract public static function getFunctionArguments(): string;

    /**
     * Return the RETURNS for the function.
     */
    abstract public static function getFunctionReturn(): string;

    /**
     * Return the SQL query for the function.
     *
     * This is the function body without the definition syntax surround it.
     */
    abstract public static function getFunctionStatement(): string;

    /**
     * Return the SQL for creating the function.
     */
    public static function create(): string
    {
        $function = rtrim(rtrim(static::getFunctionStatement(), ';'));

        $sql = <<< 'SQL'
CREATE OR REPLACE FUNCTION %s(%s) RETURNS %s AS
$body$
%s
$body$
LANGUAGE 'sql' IMMUTABLE STRICT;
SQL;

        return sprintf(
            $sql,
            static::getFunctionName(),
            static::getFunctionArguments(),
            static::getFunctionReturn(),
            $function
        );
    }

    /**
     * Return the SQL for destroying the function.
     */
    public static function destroy(): string
    {
        return sprintf(
            'DROP FUNCTION IF EXISTS %s(%s);',
            static::getFunctionName(),
            static::getFunctionArguments()
        );
    }
}
