<?php

declare(strict_types=1);

namespace Brain\Common\Debug;

/**
 * An interface that should be implemented for developer experience.
 */
interface DebugInterface
{
    /**
     * Return a string representation for debug.
     *
     * Please keep the class name represented at the beginning, maybe just the short name.
     * Things to consider representing are the id(s), if its persisted and various readable names.
     * Also information that is important to the context of the entity.
     *
     * @example User(id=xyz, email=bob@bob.com, name=Bob)
     * @example PrintDevice(id=xyz, manufacturer=Xeicon, model=T2000)
     * @example TwoDimensional{width=5, height=5}
     *
     * @see DebugHelper
     */
    public function toString(bool $short): string;

    /**
     * Enforce the implementation of the magic method to allow developer tools to better represent this entity.
     *
     * Please do not use casting to string to get the representation!
     *
     * Tools such as sentry and loggers will attempt to call this before resorting to just the class name.
     * This method should just proxy the {@link toString()} method defined in this entity also.
     */
    public function __toString(): string;
}
