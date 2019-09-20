<?php

declare(strict_types=1);

namespace Brain\Common\Math\Exception\Range;

use Exception;

final class IntegerRangeNotPositiveException extends Exception
{
    /** @var int */
    private $start;

    /** @var int */
    private $finish;

    /**
     * @return IntegerRangeNotPositiveException
     */
    public static function create(int $start, int $finish): self
    {
        return new self($start, $finish);
    }

    public function __construct(int $start, int $finish)
    {
        $message = 'The integer range must be positive, finish value %d must be greater or equal to start %d.';
        $message = sprintf($message, $start, $finish);

        parent::__construct($message);

        $this->start = $start;
        $this->finish = $finish;
    }

    /**
     * Return the range start.
     */
    public function getRangeStart(): int
    {
        return $this->start;
    }

    /**
     * Return the range finish.
     */
    public function getRangeFinish(): int
    {
        return $this->finish;
    }
}
