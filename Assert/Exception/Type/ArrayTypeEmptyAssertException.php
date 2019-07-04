<?php

declare(strict_types=1);

namespace Brain\Common\Assert\Exception\Type;

use Exception;

/**
 * An array type assertion exception when the array is empty.
 */
final class ArrayTypeEmptyAssertException extends Exception
{
    /**
     * @return ArrayTypeEmptyAssertException
     */
    public static function create(string $property): self
    {
        return new self($property);
    }

    public function __construct(string $property)
    {
        $message = sprintf('The given array (%s) cannot be empty.', $property);

        parent::__construct($message);
    }
}
