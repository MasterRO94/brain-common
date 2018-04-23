<?php

namespace Brain\Common\Date;

use DateTimeInterface;

interface DateTimeFactoryInterface
{
    /**
     * Create a new date.
     *
     * @return DateTimeInterface
     */
    public function create(): DateTimeInterface;
}
