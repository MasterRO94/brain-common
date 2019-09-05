<?php

declare(strict_types=1);

namespace Brain\Common\Math\Exception\Percentage;

use Exception;

final class PercentageBoundExceededException extends Exception
{
    /** @var float */
    private $value;

    /**
     * @return PercentageBoundExceededException
     */
    public static function create(float $value): self
    {
        return new self($value);
    }

    public function __construct(float $value)
    {
        $message = 'The value provided (%d) is an invalid percentage value.';
        $message = sprintf($message, $value);

        parent::__construct($message);

        $this->value = $value;
    }

    /**
     * Return the invalid percentage value.
     */
    public function getInvalidValue(): float
    {
        return $this->value;
    }
}
