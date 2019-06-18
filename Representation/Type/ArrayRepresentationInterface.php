<?php

declare(strict_types=1);

namespace Brain\Common\Representation\Type;

/**
 * Enforce an object allows array representation.
 */
interface ArrayRepresentationInterface
{
    /**
     * Represent the value as a array.
     *
     * @return mixed[]
     */
    public function toArray(): array;
}
