<?php

namespace Brain\Common\Utility;

interface UniqueIdentityFactoryInterface
{
    /**
     * Generate a unique uuid v4.
     *
     * @return string
     */
    public function uuid(): string;
}
