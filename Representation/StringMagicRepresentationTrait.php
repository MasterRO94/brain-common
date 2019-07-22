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
     *
     * @see https://github.com/phpstan/phpstan/issues/2271 For a reason as to why this code looks weird.
     */
    public function __toString(): string
    {
        /** @var object $object */
        $object = $this;

        if ($object instanceof StringRepresentationInterface) {
            return $object->toString();
        }

        /** @var object $object */
        $object = $this;

        if ($object instanceof DebugRepresentationInterface) {
            return $object->toDebug(true);
        }

        return (new ReflectionObject($this))->getShortName();
    }
}
