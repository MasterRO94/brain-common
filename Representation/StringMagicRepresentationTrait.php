<?php

declare(strict_types=1);

namespace Brain\Common\Representation;

use Brain\Common\Debug\Representation\DebugRepresentationInterface;
use Brain\Common\Representation\Type\StringRepresentationInterface;

use ReflectionObject;

/**
 * A trait that helps implement the magic functionality.
 */
trait StringMagicRepresentationTrait
{
    /**
     * Implements magic casting to string.
     */
    public function __toString(): string
    {
        if ($this instanceof StringRepresentationInterface) {
            return $this->toString();
        }

        if ($this instanceof DebugRepresentationInterface) {
            return $this->toDebug(true);
        }

        return (new ReflectionObject($this))->getShortName();
    }
}
