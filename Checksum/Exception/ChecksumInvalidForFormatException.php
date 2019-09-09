<?php

declare(strict_types=1);

namespace Brain\Common\Checksum\Exception;

use Exception;

final class ChecksumInvalidForFormatException extends Exception
{
    /** @var string */
    private $format;

    /** @var string */
    private $value;

    /**
     * @return ChecksumInvalidForFormatException
     */
    public static function create(string $format, string $value): self
    {
        return new self($format, $value);
    }

    public function __construct(string $format, string $value)
    {
        $message = 'The checksum value "%s" is invalid for format "%s".';
        $message = sprintf($message, $value, $format);

        parent::__construct($message);

        $this->format = $format;
        $this->value = $value;
    }

    /**
     * Return the checksum format.
     */
    public function getChecksumFormat(): string
    {
        return $this->format;
    }

    /**
     * Return the checksum value that was invalid.
     */
    public function getInvalidValue(): string
    {
        return $this->value;
    }
}
