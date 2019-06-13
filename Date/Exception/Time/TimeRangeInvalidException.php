<?php

declare(strict_types=1);

namespace Brain\Common\Date\Exception\Time;

use Brain\Common\Date\Time\Time;

use Exception;

final class TimeRangeInvalidException extends Exception
{
    public function __construct(Time $lower, Time $higher)
    {
        $message = implode(' ', [
            'A time range cannot be constructed with lower "%s" and higher "%s".',
            'The lower time should not be greater than the higher time.',
        ]);

        $message = sprintf(
            $message,
            $lower->toString(),
            $higher->toString()
        );

        parent::__construct($message);
    }

    /**
     * @return TimeRangeInvalidException
     */
    public static function create(Time $lower, Time $higher): self
    {
        return new self($lower, $higher);
    }
}
