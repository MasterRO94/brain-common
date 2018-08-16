<?php

declare(strict_types=1);

namespace Brain\Common\Dimension;

/**
 * {@inheritdoc}
 */
final class TwoDimensional implements TwoDimensionalInterface
{
    private $width;
    private $height;

    /**
     * Return a zero'd two dimensional.
     *
     * @return TwoDimensional
     */
    public static function createZero(): self
    {
        return new self(0, 0);
    }

    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

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
