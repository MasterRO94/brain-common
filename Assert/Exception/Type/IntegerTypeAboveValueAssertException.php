<?php

declare(strict_types=1);

namespace Brain\Common\Assert\Exception\Type;

use Exception;

final class IntegerTypeAboveValueAssertException extends Exception
{
    /**
     * @return IntegerTypeAboveValueAssertException
     */
    public static function create(int $value, int $threshold, string $property): self
    {
        return new self($value, $threshold, $property);
    }

    public function __construct(int $value, int $threshold, string $property)
    {
        $message = 'The given integer value (%s) %d is not above %d';
        $message = sprintf($message, $property, $value, $threshold);

        parent::__construct($message);
    }
}
