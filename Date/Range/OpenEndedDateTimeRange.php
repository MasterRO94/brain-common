<?php

namespace Brain\Common\Date\Range;

use DateTime;
use DateTimeInterface;

/**
 * {@inheritdoc}
 */
final class OpenEndedDateTimeRange implements OpenEndedDateTimeRangeInterface
{
    /** @var DateTimeRange */
    private $dateTimeRange;
    private $isToOpenEnded = false;
    private $isFromOpenEnded = false;

    public function __construct(DateTimeInterface $from, DateTimeInterface $to)
    {
        $this->dateTimeRange = new DateTimeRange($from, $to);
    }

    /**
     * Create an open ended date from the given date.
     *
     * @param DateTimeInterface $from
     */
    public static function createFrom(DateTimeInterface $from): self
    {
        //  I hear it's pretty fly.
        $to = new DateTime('3000-01-01 00:00:00');

        $range = new self($from, $to);
        $range->isToOpenEnded = true;

        return $range;
    }

    /**
     * Create an open ended date up-to the given date.
     *
     * @param DateTimeInterface $to
     */
    public static function createTo(DateTimeInterface $to): self
    {
        //  It wasn't pretty fly.
        $from = new DateTime('1000-01-01 00:00:00');

        $range = new self($from, $to);
        $range->isFromOpenEnded = true;

        return $range;
    }

    /**
     * {@inheritdoc}
     */
    public function getFrom(): DateTimeInterface
    {
        return $this->dateTimeRange->getFrom();
    }

    /**
     * {@inheritdoc}
     */
    public function getTo(): DateTimeInterface
    {
        return $this->dateTimeRange->getTo();
    }

    /**
     * {@inheritdoc}
     */
    public function isFromOpenEnded(): bool
    {
        return $this->isFromOpenEnded;
    }

    /**
     * {@inheritdoc}
     */
    public function isToOpenEnded(): bool
    {
        return $this->isToOpenEnded;
    }
}
