<?php

declare(strict_types=1);

namespace Brain\Common\Exception\Developer;

use RuntimeException;
use Throwable;

/**
 * This is a developer contract exception that can be used to silence exception notices
 * in the code base where they make no sense. Use this sparingly and do not just revert
 * to throwing this instead.
 *
 * Usage of this should be for value objects only. For example static factory method
 * that provides an enum value you can use this to silence the enum exceptions.
 */
final class DeveloperContractRuntimeException extends RuntimeException
{
    public function __construct(Throwable $previous)
    {
        $message = 'A developer contract error: %s';
        $message = sprintf($message, $previous->getMessage());

        parent::__construct($message, 0, $previous);
    }

    /**
     * @return DeveloperContractRuntimeException
     */
    public static function create(Throwable $previous): self
    {
        return new self($previous);
    }
}
