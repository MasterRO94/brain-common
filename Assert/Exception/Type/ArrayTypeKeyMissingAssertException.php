<?php

declare(strict_types=1);

namespace Brain\Common\Assert\Exception\Type;

use Exception;

final class ArrayTypeKeyMissingAssertException extends Exception
{
    /**
     * @return ArrayTypeKeyMissingAssertException
     */
    public static function create(string $key, string $property): self
    {
        return new self($key, $property);
    }

    public function __construct(string $key, string $property)
    {
        $message = sprintf('The given array (%s) must contain the key "%s"', $property, $key);

        parent::__construct($message);
    }
}
