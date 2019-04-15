<?php

declare(strict_types=1);

namespace Brain\Common\Date\Relative;

use DateTimeImmutable;
use DateTimeInterface;

/**
 * A specialised date time helper.
 */
final class DateTimeRelativeHelper implements DateTimeRelativeFormatInterface
{
    /**
     * Create a date time (ignoring the time) using relative formats supported by "strtotime()".
     */
    public static function createRelativeDate(string $format, DateTimeInterface $base): DateTimeImmutable
    {
        $timestamp = strtotime($format, $base->getTimestamp());

        return new DateTimeImmutable(sprintf('@%d', $timestamp));
    }
}
