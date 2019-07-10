<?php

declare(strict_types=1);

namespace Brain\Common\Dimension;

use Brain\Common\Debug\Representation\DebugRepresentationInterface;
use Brain\Common\Debug\Representation\DebugRepresentationTrait;
use Brain\Common\Prototype\NullObjectRepresentationInterface;

/**
 * A null instance of two dimensional that can be used in place of null.
 *
 * @deprecated
 */
final class NullTwoDimensional implements
    NullObjectRepresentationInterface,
    TwoDimensionalInterface,
    DebugRepresentationInterface
{
    use DebugRepresentationTrait;

    /**
     * {@inheritdoc}
     */
    public function getWidth(): int
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeight(): int
    {
        return 0;
    }

    /**
     * {@inheritdoc}
     */
    public function isSquare(): bool
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return '0x0';
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'width' => 0,
            'height' => 0,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function toDebugParameters(): array
    {
        return [];
    }
}
