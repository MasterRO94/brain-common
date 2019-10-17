<?php

declare(strict_types=1);

namespace Brain\Common\Database\Builder;

/**
 * An abstract view definition.
 */
abstract class AbstractViewBuilder
{
    /**
     * Return the name of the view.
     */
    abstract public static function getViewName(): string;

    /**
     * Return the SQL query for the select on the view.
     *
     * This is the view body without the definition syntax surround it.
     */
    abstract public static function getSelectStatement(): string;

    /**
     * Return the parameters for the select statement.
     *
     * @return string[]
     */
    public static function getSelectStatementParameters(): array
    {
        return [];
    }

    /**
     * Return the SQL for creating the view.
     */
    public static function create(): string
    {
        $statement = rtrim(rtrim(static::getSelectStatement(), ';'));
        $statement = strtr($statement, static::getSelectStatementParameters());

        return sprintf("CREATE VIEW \"%s\" AS\n%s;\n\n", static::getViewName(), $statement);
    }

    /**
     * Return the SQL for destroying the view.
     */
    public static function destroy(): string
    {
        return sprintf('DROP VIEW IF EXISTS "%s";', static::getViewName());
    }
}
