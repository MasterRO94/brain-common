<?php

declare(strict_types=1);

namespace Brain\Common\Date\Exception\Time;

use Brain\Common\Date\Assert\TimeAssert;

use Exception;

final class TimeInvalidHourException extends Exception
{
    /**
     * {@inheritdoc}
     */
    public static function create(int $hour): self
    {
        return new self(
            $hour,
            TimeAssert::TIME_HOUR_MINIMUM,
            TimeAssert::TIME_HOUR_MAXIMUM
        );
    }

    public function __construct(int $hour, int $minimum, int $maximum)
    {
        $message = implode(' ', [
            'The value %d is not a valid hour.',
            'Please provide a valid integer value between (inclusive) %d and %d.',
        ]);

        $message = sprintf($message, $hour, $minimum, $maximum);

        parent::__construct($message);
    }
}
