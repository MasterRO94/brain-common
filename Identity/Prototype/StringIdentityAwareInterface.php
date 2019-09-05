<?php

declare(strict_types=1);

namespace Brain\Common\Identity\Prototype;

use Brain\Common\Identity\StringIdentityInterface;
use Brain\Common\Representation\Type\StringRepresentationInterface;

/**
 * An object that has a string identity.
 */
interface StringIdentityAwareInterface extends
    StringRepresentationInterface
{
    /**
     * Return the identity.
     */
    public function getId(): StringIdentityInterface;
}
