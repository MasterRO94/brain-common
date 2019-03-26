<?php

declare(strict_types=1);

namespace Brain\Common\Debug;

/**
 * @mixin DebugInterface
 */
trait DebugTrait
{
    /**
     * @see DebugInterface::toString()
     */
    public function __toString(): string
    {
        return $this->toString(false);
    }

    /**
     * @see DebugInterface::toString()
     */
    public function toString(bool $short): string
    {
        return DebugHelper::represent($this, $this->toStringParameters(), $short);
    }

    /**
     * Return the parameters for strings.
     *
     * @return mixed[]
     */
    protected function toStringParameters(): array
    {
        return [];
    }
}
