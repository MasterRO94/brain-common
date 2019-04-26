<?php

declare(strict_types=1);

namespace Brain\Common\Database\Query;

use Brain\Common\Database\Exception\DatabaseQueryException;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\ResultStatement;

use PDO;

/**
 * An abstract database query.
 */
abstract class AbstractDatabaseQuery
{
    public const PARAM_NULL = PDO::PARAM_NULL;
    public const PARAM_STRING = PDO::PARAM_STR;
    public const PARAM_INTEGER = PDO::PARAM_INT;
    public const PARAM_INTEGER_ARRAY = Connection::PARAM_INT_ARRAY;

    /** @var mixed[] */
    private $parameters = [];

    /** @var mixed[] */
    private $parameterTypes = [];

    /**
     * Build the SQL statement for querying.
     */
    abstract public function build(Connection $connection): string;

    /**
     * Execute the query and return the value object.
     *
     * @return mixed
     */
    abstract public function execute(Connection $connection);

    /**
     * Set a query parameter.
     *
     * @param mixed $value
     * @param int|null $type
     */
    final protected function parameter(string $key, $value, $type = null): void
    {
        $this->parameters[$key] = $value;
        $this->parameterTypes[$key] = $type;
    }

    /**
     * Run the query against the given connection.
     */
    final protected function runQueryForConnection(Connection $connection): ResultStatement
    {
        $sql = $this->build($connection);
        $sql = sprintf("-- %s\n%s", static::class, $sql);

        try {
            return $connection->executeQuery($sql, $this->parameters, $this->parameterTypes);
        } catch (DBALException $exception) {
            $message = explode(":\n\n", $exception->getMessage());

            throw new DatabaseQueryException($message[1] ?? 'Unknown issue.', $exception);
        }
    }
}
