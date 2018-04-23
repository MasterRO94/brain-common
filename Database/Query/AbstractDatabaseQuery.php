<?php

namespace Brain\Common\Database\Query;

use Brain\Common\Database\Exception\DatabaseQueryException;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\ResultStatement;

/**
 * An abstract database query.
 *
 * @api
 */
abstract class AbstractDatabaseQuery
{
    const PARAM_NULL = \PDO::PARAM_NULL;
    const PARAM_INTEGER = \PDO::PARAM_INT;
    const PARAM_INTEGER_ARRAY = Connection::PARAM_INT_ARRAY;

    private $parameters = [];
    private $parameterTypes = [];

    /**
     * Build the SQL statement for querying.
     *
     * @param Connection $connection
     *
     * @return string
     *
     * @api
     */
    abstract public function build(Connection $connection): string;

    /**
     * Execute the query and return the value object.
     *
     * @param Connection $connection
     *
     * @return mixed
     *
     * @api
     */
    abstract public function execute(Connection $connection);

    /**
     * Set a query parameter.
     *
     * @param string $key
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
     *
     * @param Connection $connection
     *
     * @return ResultStatement
     */
    final protected function runQueryForConnection(Connection $connection): ResultStatement
    {
        $sql = $this->build($connection);
        $sql = sprintf("-- %s\n%s", get_called_class(), $sql);

        try {
            return $connection->executeQuery($sql, $this->parameters, $this->parameterTypes);
        } catch (DBALException $exception) {
            $message = explode(":\n\n", $exception->getMessage());

            throw new DatabaseQueryException($message[1] ?? 'Unknown issue.', $exception);
        }
    }
}
