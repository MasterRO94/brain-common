<?php

declare(strict_types=1);

namespace Brain\Common\Date;

use DateTimeImmutable;
use DateTimeInterface;

interface DateTimeFactoryInterface
{
    /**
     * Create a new date.
     *
     * @deprecated Please consider using immutable instances instead.
     */
    public function create(): DateTimeInterface;

    /**
     * Create a new datetime immutable.
     */
    public function createImmutable(): DateTimeImmutable;
}
