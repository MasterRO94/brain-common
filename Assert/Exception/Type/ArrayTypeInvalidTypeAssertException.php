<?php

declare(strict_types=1);

namespace Brain\Common\Assert\Exception\Type;

use Exception;

/**
 * An array type assertion exception when the array is not of a fixed type.
 */
final class ArrayTypeInvalidTypeAssertException extends Exception
{
    /**
     * @return ArrayTypeInvalidTypeAssertException
     */
    public static function create(string $property, string $type): self
    {
        return new self($property, $type);
    }

    public function __construct(string $property, string $type)
    {
        $message = sprintf('The given array (%s) must be an array of %s', $property, $type);

        parent::__construct($message);
    }
}
