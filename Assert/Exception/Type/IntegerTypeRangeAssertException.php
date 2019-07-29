<?php

declare(strict_types=1);

namespace Brain\Common\Assert\Exception\Type;

use Exception;

final class IntegerTypeRangeAssertException extends Exception
{
    /**
     * @return IntegerTypeRangeAssertException
     */
    public static function create(int $value, int $lower, int $upper): self
    {
        return new self($value, $lower, $upper);
    }

    public function __construct(int $value, int $lower, int $upper)
    {
        $message = 'The given value %d is not within the expected range %d to %d';
        $message = sprintf($message, $value, $lower, $upper);

        parent::__construct($message);
    }
}
