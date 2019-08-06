<?php

declare(strict_types=1);

namespace Brain\Common\Exception\Developer;

use RuntimeException;

final class MethodNotImplementedRuntimeException extends RuntimeException
{
    /**
     * @return MethodNotImplementedRuntimeException
     */
    public static function create(string $method, string $class): self
    {
        return new self($method, $class);
    }

    public function __construct(string $method, string $class)
    {
        $message = 'The method "%s" on class "%s" cannot be called because it is not implemented.';
        $message = sprintf($message, $method, $class);

        parent::__construct($message);
    }
}
