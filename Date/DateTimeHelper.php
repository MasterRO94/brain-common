<?php

declare(strict_types=1);

namespace Brain\Common\Date;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;

/**
 * @see https://tools.ietf.org/html/rfc3339
 */
final class DateTimeHelper
{
    private const RFC3339 = 'Y-m-d\TH:i:sP';

    /**
     * A converter to make all date times standard.
     */
    public static function convert(DateTimeInterface $date): DateTimeInterface
    {
        if ($date instanceof DateTimeImmutable) {
            return $date;
        }

        if ($date instanceof DateTime) {
            return DateTimeImmutable::createFromMutable($date);
        }

        $format = static::format($date);

        return new DateTimeImmutable($format);
    }

    /**
     * Return the date in a standardised format.
     */
    public static function format(DateTimeInterface $date): string
    {
        return $date->format(self::RFC3339);
    }
}
