<?php

namespace Brain\Common\Date\Range;

/**
 * An open ended range of date times.
 */
interface OpenEndedDateTimeRangeInterface extends DateTimeRangeInterface
{
    /**
     * Does the date range have an open ended "from" date.
     *
     * Example, anything below the "to" date.
     */
    public function isFromOpenEnded(): bool;

    /**
     * Does the date range have an open ended "to" date.
     *
     * Example, anything above the "from" date.
     */
    public function isToOpenEnded(): bool;
}
