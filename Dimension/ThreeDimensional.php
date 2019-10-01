<?php

declare(strict_types=1);

namespace Brain\Common\Dimension;

use Brain\Common\Debug\Representation\DebugRepresentationInterface;
use Brain\Common\Debug\Representation\DebugRepresentationTrait;
use Brain\Common\Spacial\Area;
use Brain\Common\Spacial\AreaInterface;
use Brain\Common\Spacial\Volume;
use Brain\Common\Spacial\VolumeInterface;

/**
 * {@inheritdoc}
 */
final class ThreeDimensional implements
    ThreeDimensionalInterface,
    DebugRepresentationInterface
{
    use DebugRepresentationTrait;

    /** @var int */
    protected $width;

    /** @var int */
    protected $height;

    /** @var int */
    protected $depth;

    /**
     * Return a zero'd three dimensional.
     *
     * @return ThreeDimensional
     */
    public static function createZero(): self
    {
        return new self(0, 0, 0);
    }

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
    public function getArea(): AreaInterface
    {
        return Area::createFromTwoDimensional($this);
    }

    /**
     * Return the volume of the three dimensional.
     */
    public function getVolume(): VolumeInterface
    {
        return Volume::createFromThreeDimensional($this);
    }

    /**
     * {@inheritdoc}
     */
    public function isSquare(): bool
    {
        // Nothing is not square, its nothing.
        if ($this->width === 0 && $this->height === 0) {
            return false;
        }

        return $this->width === $this->height;
    }

    /**
     * {@inheritdoc}
     */
    public function isCube(): bool
    {
        // Nothing is not cube, its nothing.
        if ($this->width === 0 && $this->height === 0 && $this->depth === 0) {
            return false;
        }

        return $this->width === $this->height && $this->height === $this->depth;
    }

    /**
     * {@inheritdoc}
     */
    public function toString(): string
    {
        return sprintf('%sx%sx%s', $this->width, $this->height, $this->depth);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray(): array
    {
        return [
            'width' => $this->getWidth(),
            'height' => $this->getHeight(),
            'depth' => $this->getDepth(),
        ];
    }
}
