<?php

declare(strict_types=1);

namespace Brain\Common\Date\Helper;

use DateTimeImmutable;
use DateTimeInterface;

/**
 * A specialised date time helper.
 */
final class DateTimeHelper implements DateTimeRelativeFormatInterface
{
    /**
     * Create a date time (ignoring the time) using relative formats supported by "strtotime()".
     */
    public static function createRelativeDate(string $format, DateTimeInterface $base): DateTimeImmutable
    {
        $timestamp = strtotime($format, $base->getTimestamp());
        $string = date('Y-m-d', $timestamp);

        return new DateTimeImmutable($string);
    }
}
