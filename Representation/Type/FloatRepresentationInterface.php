<?php

declare(strict_types=1);

namespace Brain\Common\Representation\Type;

/**
 * Enforce an object allows floating point number representation.
 */
interface FloatRepresentationInterface
{
    /**
     * Represent the value as a floating point number.
     */
    public function toFloat(): float;
}
