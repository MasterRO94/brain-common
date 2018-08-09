<?php

declare(strict_types=1);

namespace Brain\Common\Date\Range;

use DateTimeInterface;

/**
 * A range of date times.
 */
interface DateTimeRangeInterface
{
    /**
     * Return the "from" (start/beginning) date.
     */
    public function getFrom(): DateTimeInterface;

    /**
     * Return the "to" (end/finish) date.
     */
    public function getTo(): DateTimeInterface;
}
