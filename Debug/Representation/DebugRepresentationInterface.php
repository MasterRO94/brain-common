<?php

declare(strict_types=1);

namespace Brain\Common\Debug\Representation;

/**
 * An interface providing a better debug experience for developers.
 *
 * This interface allows a developer to apply a custom serialization to their objects.
 */
interface DebugRepresentationInterface
{
    /**
     * Return a string representation for debug.
     *
     * Please keep the class name represented at the beginning, maybe just the short name.
     * Things to consider representing are the id(s), if its persisted and various readable names.
     * Also information that is important to the context of the entity.
     *
     * @see DebugRepresentation
     *
     * @example User(id=xyz, email=bob@bob.com, name=Bob)
     * @example PrintDevice(id=xyz, manufacturer=Xeicon, model=T2000)
     * @example TwoDimensional{width=5, height=5}
     */
    public function toDebug(bool $short): string;
}
