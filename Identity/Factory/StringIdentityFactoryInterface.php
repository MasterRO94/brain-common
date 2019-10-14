<?php

declare(strict_types=1);

namespace Brain\Common\Identity\Factory;

use Brain\Common\Identity\StringIdentityInterface;

/**
 * A factory for creating string identities.
 */
interface StringIdentityFactoryInterface
{
    /**
     * Create a new identity with random (and unique) identity.
     */
    public function create(): StringIdentityInterface;
}
