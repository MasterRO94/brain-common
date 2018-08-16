<?php

declare(strict_types=1);

namespace Brain\Common\Dimension;

use Brain\Common\Prototype\NullObjectRepresentationInterface;

/**
 * A null instance of two dimensional that can be used in place of null.
 */
final class NullTwoDimensional implements
    NullObjectRepresentationInterface,
    TwoDimensionalInterface
{
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
}
