<?php

declare(strict_types=1);

namespace Brain\Common\Date;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;

/**
 * A date time factory.
 *
 * Note this class isn't fully fleshed out.
 */
final class DateTimeFactory implements DateTimeFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(): DateTimeInterface
    {
        return new DateTime();
    }

    /**
     * {@inheritdoc}
     */
    public function createImmutable(): DateTimeImmutable
    {
        return new DateTimeImmutable();
    }
}
