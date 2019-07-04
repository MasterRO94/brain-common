<?php

namespace Brain\Common\Assert\Exception\Type;

/**
 * An array type assertion exception when the array is empty.
 */
final class ArrayTypeEmptyAssertException extends \Exception
{
    public function __construct()
    {
        $message = 'The given array cannot be empty.';

        parent::__construct($message);
    }

    /**
     * @return ArrayTypeEmptyAssertException
     */
    public static function create(): self
    {
        return new self();
    }
}
