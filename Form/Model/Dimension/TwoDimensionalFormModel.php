<?php

declare(strict_types=1);

namespace Brain\Common\Form\Model\Dimension;

use Brain\Common\Dimension\TwoDimensionalInterface;

/**
 * {@inheritdoc}
 *
 * @internal
 */
final class TwoDimensionalFormModel implements TwoDimensionalInterface
{
    /** @var int */
    public $width;

    /** @var int */
    public $height;

    /**
     * {@inheritdoc}
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * {@inheritdoc}
     */
    public function isSquare(): bool
    {
        return $this->width === $this->height;
    }
}
