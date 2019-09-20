<?php

declare(strict_types=1);

namespace Brain\Common\Type\Exception;

use Exception;

final class StringNotNumericException extends Exception
{
    /**
     * @return StringNotNumericException
     */
    public static function create(string $value): self
    {
        return new self($value);
    }

    public function __construct(string $value)
    {
        $message = 'The string "%s" is not numeric.';
        $message = sprintf($message, $value);

        parent::__construct($message);
    }
}
