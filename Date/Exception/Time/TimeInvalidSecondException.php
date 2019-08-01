<?php

declare(strict_types=1);

namespace Brain\Common\Date\Exception\Time;

use Brain\Common\Date\Assert\TimeAssert;

use Exception;

final class TimeInvalidSecondException extends Exception
{
    /**
     * {@inheritdoc}
     */
    public static function create(int $second): self
    {
        return new self(
            $second,
            TimeAssert::TIME_SECOND_MINIMUM,
            TimeAssert::TIME_SECOND_MAXIMUM
        );
    }

    public function __construct(int $second, int $minimum, int $maximum)
    {
        $message = implode(' ', [
            'The value %d is not a valid second.',
            'Please provide a valid integer value between (inclusive) %d and %d.',
        ]);

        $message = sprintf($message, $second, $minimum, $maximum);

        parent::__construct($message);
    }
}
