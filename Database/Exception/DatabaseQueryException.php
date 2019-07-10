<?php

declare(strict_types=1);

namespace Brain\Common\Database\Exception;

use Exception;
use Throwable;

/**
 * {@inheritdoc}
 */
final class DatabaseQueryException extends Exception
{
    public function __construct(string $message, ?Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }
}
