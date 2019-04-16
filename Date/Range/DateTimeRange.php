<?php

declare(strict_types=1);

namespace Brain\Common\Date\Range;

use DateTimeInterface;

/**
 * {@inheritdoc}
 */
final class DateTimeRange implements DateTimeRangeInterface
{
    /** @var DateTimeInterface */
    private $from;

    /** @var DateTimeInterface */
    private $to;

    public function __construct(DateTimeInterface $from, DateTimeInterface $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * {@inheritdoc}
     */
    public function getFrom(): DateTimeInterface
    {
        return $this->from;
    }

    /**
     * {@inheritdoc}
     */
    public function getTo(): DateTimeInterface
    {
        return $this->to;
    }
}
