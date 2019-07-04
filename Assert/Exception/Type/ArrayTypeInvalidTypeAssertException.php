<?php

namespace Brain\Common\Assert\Exception\Type;

/**
 * An array type assertion exception when the array is not of a fixed type.
 */
final class ArrayTypeInvalidTypeAssertException extends \Exception
{
    public function __construct(string $type)
    {
        $message = sprintf('The given array must be an array of %s(s).', $type);

        parent::__construct($message);
    }

    /**
     * @return ArrayTypeInvalidTypeAssertException
     */
    public static function create(string $type): self
    {
        return new self($type);
    }
}
