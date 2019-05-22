<?php

declare(strict_types=1);

namespace Brain\Common\Enum\Exception;

use RuntimeException;

/**
 * An exception to let the developer know the enum has no values.
 */
final class EmptyEnumException extends RuntimeException
{
    public function __construct(string $enum)
    {
        $message = implode(' ', [
            'An enum has no values, please make sure the enum is configured correctly.',
            'The offending enum is: %s',
        ]);

        $message = sprintf($message, $enum);

        parent::__construct($message);
    }

    /**
     * @return EmptyEnumException
     */
    public static function create(string $enum): self
    {
        return new self($enum);
    }
}
