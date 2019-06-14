<?php

namespace Brain\Common\Representation\Type;

/**
 * Enforce an object allows string representation.
 */
interface StringRepresentationInterface
{
    /**
     * Represent the value as a string.
     */
    public function toString(): string;
}
