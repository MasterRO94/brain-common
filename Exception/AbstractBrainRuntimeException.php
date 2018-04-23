<?php

namespace Brain\Common\Exception;

use RuntimeException;
use Throwable;

/**
 * A runtime exception for brain common.
 */
abstract class AbstractBrainRuntimeException extends RuntimeException
{
    /**
     * Constructor.
     *
     * @param string $message
     * @param Throwable|null $previous
     */
    public function __construct(string $message = '', Throwable $previous = null)
    {
        $code = 0;

        parent::__construct($message, $code, $previous);
    }
}
