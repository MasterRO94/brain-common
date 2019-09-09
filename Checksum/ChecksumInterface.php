<?php

declare(strict_types=1);

namespace Brain\Common\Checksum;

use Brain\Common\Representation\Type\StringRepresentationInterface;

/**
 * A checksum.
 */
interface ChecksumInterface extends
    StringRepresentationInterface
{
    /**
     * Return the type of checksum.
     */
    public function format(): string;
}
