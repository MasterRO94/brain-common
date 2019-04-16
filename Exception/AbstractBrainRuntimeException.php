<?php

declare(strict_types=1);

namespace Brain\Common\Exception;

use RuntimeException;
use Throwable;

/**
 * A runtime exception for brain common.
 *
 * @deprecated
 */
abstract class AbstractBrainRuntimeException extends RuntimeException
{
    public function __construct(string $message = '', ?Throwable $previous = null)
    {
        $code = 0;

        parent::__construct($message, $code, $previous);
    }
}
