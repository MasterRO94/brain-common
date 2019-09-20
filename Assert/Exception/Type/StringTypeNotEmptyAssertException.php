<?php

declare(strict_types=1);

namespace Brain\Common\Assert\Exception\Type;

use Exception;

final class StringTypeNotEmptyAssertException extends Exception
{
    /**
     * @return StringTypeNotEmptyAssertException
     */
    public static function create(string $property): self
    {
        return new self($property);
    }

    public function __construct(string $property)
    {
        $message = 'The given string value (%s) cannot be empty';
        $message = sprintf($message, $property);

        parent::__construct($message);
    }
}
