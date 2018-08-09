<?php

declare(strict_types=1);

namespace Brain\Common\Date;

use DateTimeInterface;

interface DateTimeFactoryInterface
{
    /**
     * Create a new date.
     */
    public function create(): DateTimeInterface;
}
