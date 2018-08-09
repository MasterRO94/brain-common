<?php

declare(strict_types=1);

namespace Brain\Common\Utility;

interface UniqueIdentityFactoryInterface
{
    /**
     * Generate a unique uuid v4.
     */
    public function uuid(): string;
}
