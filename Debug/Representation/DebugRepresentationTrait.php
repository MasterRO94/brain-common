<?php

declare(strict_types=1);

namespace Brain\Common\Debug\Representation;

use Brain\Common\Representation\StringMagicRepresentationTrait;
use Brain\Common\Representation\Type\ArrayRepresentationInterface;

/**
 * @mixin DebugRepresentationInterface
 */
trait DebugRepresentationTrait
{
    use StringMagicRepresentationTrait;

    /**
     * @see DebugRepresentationInterface::toDebug()
     */
    public function toDebug(bool $short): string
    {
        return DebugRepresentation::represent($this, $this->toDebugParameters(), $short);
    }

    /**
     * Return the parameters for debug strings.
     *
     * Note, assuming the object can be represented as an array it will automatically grab those.
     * To make sure this doesn't happen override the method and return an empty array.
     *
     * @return mixed[]
     */
    protected function toDebugParameters(): array
    {
        if ($this instanceof ArrayRepresentationInterface) {
            return $this->toArray();
        }

        return [];
    }
}
