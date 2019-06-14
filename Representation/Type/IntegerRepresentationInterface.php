<?php

declare(strict_types=1);

namespace Brain\Common\Representation\Type;

/**
 * Enforce an object allows integer representation.
 */
interface IntegerRepresentationInterface
{
    /**
     * Represent the value as a integer.
     */
    public function toInteger(): int;
}
