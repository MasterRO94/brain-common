<?php

declare(strict_types=1);

namespace Brain\Common\Date\Exception\Time;

use Brain\Common\Date\Assert\TimeAssert;

use Exception;

final class TimeInvalidMinuteException extends Exception
{
    /**
     * {@inheritdoc}
     */
    public static function create(int $minute): self
    {
        return new self(
            $minute,
            TimeAssert::TIME_MINUTE_MINIMUM,
            TimeAssert::TIME_MINUTE_MAXIMUM
        );
    }

    public function __construct(int $minute, int $minimum, int $maximum)
    {
        $message = implode(' ', [
            'The value %d is not a valid minute.',
            'Please provide a valid integer value between (inclusive) %d and %d.',
        ]);

        $message = sprintf($message, $minute, $minimum, $maximum);

        parent::__construct($message);
    }
}
