<?php

declare(strict_types=1);

namespace Brain\Common\Date\Exception\Time;

use Exception;

final class TimeInvalidStringFormatException extends Exception
{
    public function __construct(string $value, string $format)
    {
        $message = implode(' ', [
            'The given value "%s" is not a valid time format.',
            'Please provide a string in the format "%s".',
        ]);

        $message = sprintf($message, $value, $format);

        parent::__construct($message);
    }

    /**
     * @return TimeInvalidStringFormatException
     */
    public static function create(string $value, string $format): self
    {
        return new self($value, $format);
    }
}
