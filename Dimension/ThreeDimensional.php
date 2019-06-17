<?php

declare(strict_types=1);

namespace Brain\Common\Dimension;

use Brain\Common\Debug\Representation\DebugRepresentationTrait;

/**
 * {@inheritdoc}
 */
final class ThreeDimensional implements
    ThreeDimensionalInterface
{
    use DebugRepresentationTrait;

    /** @var int */
    protected $width;

    /** @var int */
    protected $height;

    /** @var int */
    protected $depth;

    public function __construct(int $width, int $height, int $depth)
    {
        $this->width = $width;
        $this->height = $height;
        $this->depth = $depth;
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
    public function getDepth(): int
    {
        return $this->depth;
    }

    /**
     * {@inheritdoc}
     */
    public function isSquare(): bool
    {
        return $this->width === $this->height;
    }

    /**
     * {@inheritdoc}
     *
     * Parameters used for debug representations.
     */
    protected function toDebugParameters(): array
    {
        return [
            'width' => $this->getWidth(),
            'height' => $this->getHeight(),
            'depth' => $this->getDepth(),
        ];
    }
}
