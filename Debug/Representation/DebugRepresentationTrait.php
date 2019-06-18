<?php

declare(strict_types=1);

namespace Brain\Common\Debug\Representation;

use Brain\Common\Representation\StringMagicRepresentationTrait;

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
        return DebugRepresentationHelper::represent($this, $this->toDebugParameters(), $short);
    }

    /**
     * Return the parameters for debug strings.
     *
     * @return mixed[]
     */
    protected function toDebugParameters(): array
    {
        return [];
    }
}
